<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
 use App\Http\Requests\ContentRequest;
use App\Models\Category;
use App\Models\Content;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class ContentController extends AdminController
{
    public function index()
    {
        $data['records'] = Content::all();;
        $data['categories'] = Category::all();;
        $data['masters'] = Master::select(['name' , 'id'])->get();;
        $data['title'] = "محتوا";
        $data['path'] = "مدیریت وب سایت / محتوا";


        $data = array_merge($data, $this->data);
        return View('admin.contents', $data);
    }

    public function store(ContentRequest $request)
    {
        $this->validate($request , [
            'title' => 'required' ,
            'category_id' => 'required' ,
            'description' => 'required|min:100' ,
        ]);
        $content = new Content();
        if ($request['edit'])
            $content = Content::find($request['edit']);

        $content->title = $request['title'];
        $content->category_id = $request['category_id'];
        $content->master_id = $request['master_id'];
        $content->description = $request['description'];
        $content->visible = $request['visible'] ? 1 : 0 ;
        $content->free = $request['free'] ? 1 : 0;

        $content->save();

        return redirect("/admin/content/{$content->id}");

    }

    public function edit(Content $content){
        $data['records'] = Content::all();
        $data['categories'] = Category::all();
        $data['masters'] = Master::select(['name' , 'id'])->get();;
        $data['requestedData'] = $content;
        $data['title'] = "محتوا";
        $data['path'] = "مدیریت وب سایت / محتوا";


        $files = \App\Models\File::whereContent_id($content->id)->get();
        $data['files'] = [];
        if (count($files))
            $data['files'] = $this->get_files_array($files->toArray());

        $data = array_merge($data, $this->data);
        return View('admin.contents', $data);
    }

    private function get_files_array($files){
        $imagePreview = [] ;
        $imagePreviewConfig = [] ;
        $musicPreview = [] ;
        $musicPreviewConfig = [] ;
        $videoLink = '' ;
        $videoId = '' ;
        foreach ($files as $file){
            if ($file['type'] != 'video'){
                ${$file['type'] . 'Preview'}[] = asset($file['name']);
                ${$file['type'] . 'PreviewConfig'}[] = [
                    'caption' =>$file['type'] == 'image' ? 'تصویر' : 'صوت',
                    'url' => '/admin/remove_file/' . $file['id'] ,
                    'downloadUrl' => asset($file['name']) ,
                    'key' => $file['id'] ,
                    'size' => Storage::size(str_replace('storage/' , 'public/' , $file['name'])) ,
                ];
            }
            if ($file['type'] == 'video') {
                $videoLink = asset($file['name']);
                $videoId = $file['id'];
            }

        }

        return ([
            'imagePreviewConfig' => $imagePreviewConfig ,
            'imagePreview' => $imagePreview ,
            'musicPreviewConfig' => $musicPreviewConfig ,
            'musicPreview' => $musicPreview ,
            'videoLink' => $videoLink,
            'videoId' => $videoId
        ]);
    }



    public function uploadLargeFiles(Request $request , $content_id ) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('public/video', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            \App\Models\File::create([
                'content_id' => $content_id,
                'name' => 'storage/video/' . $fileName,
                'type' => 'video',
            ]);
            return [
                'path' => asset( str_replace('public/' , 'storage/' , $path)),
                'filename' => $fileName
            ];
        }

        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }


    public function upload_files(Request $request , $type , $content_id = '')
    {
        if ($type == 'music') $index = 'content_musics';
        if ($type == 'image') $index = 'content_images';

        $files = $request->file($index);
        $filesLink = array();

        if ($files[0] != null) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = str_replace('.'.$extension, '', $file->getClientOriginalName());
                $filename .= '_' . md5(time()) . '.' . $extension;
                Storage::disk()->put('public/' . $type . '/' . $filename, File::get($file));
                $url = Storage::disk()->url($filename);
                array_push($filesLink, $url);
                \App\Models\File::create([
                    'content_id' => $content_id,
                    'name' => 'storage/' . $type . '/' . $filename,
                    'type' => $type,
                ]);
            }
        }


        return $filesLink;
    }

    public function remove_file( \App\Models\File $file)
    {
        $temp_file = $file;
        $file_name = str_replace('storage/' , 'public/' , $file['name']);
        if (Storage::exists($file_name)){
            Storage::delete($file_name);
            $file->delete();
            if ($temp_file['type'] == 'video')
                return redirect('/admin/content/' . $temp_file['content_id']);
            return 1;
        }
        return false;

    }


}

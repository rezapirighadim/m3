@extends("admin.theme.main")
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">لیست کتب اضافه شده به فروشگاه</h3>
        </div>
        <div class="panel-body">
            <section class="row component-section">

                <!-- responsive table title and description -->

                <!-- responsive table code and example -->
                <div class="col-md-12">
                        <!-- responsive table example -->
                    <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                        <table id="example" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th class="tac">تصویر</th>
                                <th class="tac">عنوان کتاب</th>
                                <th class="tac">موجودی</th>
                                <th class="tac">دسته بندی</th>
                                <th class="tac">قیمت نمایشی</th>
                                <th class="tac">قیمت واقعی</th>
                                <th class="tac">نمایش کامل</th>
                                <th class="tac">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?
                            if(isset($books) && $books!=null){
                            foreach($books as $book){?>
                            <tr class="cat_row">
                                <td><?=$book['id'];?></td>
                                <td><img style="width: 80px ; border-radius: 1%" src="{{URL::to('/local/uploads/books/images/' . $book['imageName'])}}" alt=""></td>
                                <td class="tac"><?=mb_strlen($book['book']['title'] ) > 80 ? $book['book']['title']  = mb_substr($book['book']['title'] , 0, 77) . '...' : $book['book']['title'] ?></td>
                                <td class="tac {{$book['count'] == 0 ? 'red' : ''}}"><?=$book['count'];?> عدد </td>
                                <td class="tac"><?=\App\Category::where('id' , $book['category_id'])->pluck('title')->first();?></td>
                                <td class="tac"><?=$book['show_price'];?></td>
                                <td class="tac"><?=$book['price'];?></td>
                                <td class="tac">مشاهده</td>
                                <td class="tac">
                                    <a class="label label-yellow label-black" style="color: yellow" onclick="toggleSelect(this , <?=$book['id']?> )"><i class="fa <?=$book['is_selected'] ? 'fa-star' : 'fa-star-o'?> "></i></a>
                                    <a class=" label label-warning" href="/admin/assign_book/<?=$book['book_id']?>">ویرایش</a>
                                    <a class=" label label-danger" onclick="remove_book(this , {{$book['id']}} )">حذف</a>


                                </td>
                            </tr>
                            <?}}?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </section>



        </div>
    </div>
    <script>
        function remove_book(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_assigned_book/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log('success');
                        console.log(data);
                        parent.remove();
                        Swal.fire({"title":"محتوا با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    },
                    error: function (data) {
                        console.log('error');
                        console.log(data);
                    }
                });
            }
        }
        function toggleSelect(sender, id) {
            if (confirm("آیا مطمعن هستید ؟")) {
                sender = $(sender);
                var child = sender.find('i');
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/toggleSelect_assigned_book/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);

                        if (child.hasClass('fa-star-o'))
                            child.removeClass('fa-star-o').addClass('fa-star');
                        else
                            child.removeClass('fa-star').addClass('fa-star-o');


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }


    </script>
@endsection

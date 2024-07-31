@extends("admin.theme.main")
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">لیست کتب ثبت شده</h3>
        </div>
        <div class="panel-body">
            <section class="row component-section">

                <!-- responsive table title and description -->

                <!-- responsive table code and example -->
                <div class="col-md-12">
                    <?
                        if ($seller_limit < $book_count)
                            echo '<p class="alert alert-warning">شما قابلیت تعریف  <span class="red"> ' . $seller_limit . ' </span> کتاب الکترونیکی از <span class="red"> ' . $book_count .' </span> کتاب خود را دارید.</p>';
                        else
                            echo '<p class="alert alert-success">شما قابلیت تعریف  <span class="red">' . $book_count . '</span> کتاب الکترونیکی را دارید. </p>'
                    ?>

                        <!-- responsive table example -->
                    <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                        <table id="example" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th class="tac">تصویر</th>
                                <th class="tac">عنوان کتاب</th>
                                <th class="tac">موجودی</th>
                                <th class="tac">ناشر</th>
                                <th class="tac">دسته بندی</th>
                                <th class="tac">قیمت فیزیکی</th>
                                <th class="tac">قیمت الکترونیکی</th>
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
                                <td class="tac"><?=mb_strlen($book['title'] ) > 80 ? $book['title']  = mb_substr($book['title'] , 0, 77) . '...' : $book['title'] ?></td>
                                <td class="tac {{$book['count'] == 0 ? 'red' : ''}}"><?=$book['count'];?> عدد </td>
                                <td class="tac"><?=\App\Book::where('id' , $book['id'])->first()->publisher()->pluck('title')->first();?></td>
                                <td class="tac"><?=\App\Category::where('id' , $book['category_id'])->pluck('title')->first();?></td>
                                <td class="tac"><?=$book['price'] .  ' ریال '?></td>
                                <td class="tac"><?=$book['price_in_app'] .  ' ریال ';?></td>
                                <td class="tac">مشاهده</td>
                                <td class="tac">
                                    <a class="label label-yellow label-black" style="color: yellow" onclick="toggleSelect(this , <?=$book['id']?> )"><i class="fa <?=$book['is_selected'] ? 'fa-star' : 'fa-star-o'?> "></i></a>
                                    <a class=" label label-warning" href="/admin/books/<?=$book['id']?>">ویرایش</a>
                                    <a target="_blank"  class=" label label-info" href="/admin/book_contents/<?=$book['id']?>">محتوای کتاب</a>
                                    <a class=" label label-danger" onclick="toggle_delete_request(this , <?=$book['id']?> )">{{!$book['delete_request'] ? 'درخواست حذف' : 'لغو درخواست حذف' }}</a>

                                @if (auth()->user()->role == 'admin')
                                        <a class=" label label-danger" onclick="cat_remove(this , <?=$book['id']?> )">حذف</a>
                                    @endif

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
        function cat_remove(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_book/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        parent.remove();
                    }
                });
            }
        }
        function toggleSelect(sender, id) {
            if (confirm("آیا مطمعن هستید ؟")) {
                sender = $(sender);
                var child = sender.find('i');
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/toggleSelect/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {

                        if (child.hasClass('fa-star-o'))
                            child.removeClass('fa-star-o').addClass('fa-star');
                        else
                            child.removeClass('fa-star').addClass('fa-star-o');


                    }
                });
            }
        }

        function toggle_delete_request(sender, id) {
            if (confirm("آیا مطمعن هستید ؟")) {
                sender = $(sender);
                var child = sender.find('i');
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/toggle_delete_request/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        // location.reload();

                        if(sender.html() == 'درخواست حذف')
                            sender.html('لغو درخواست حذف')
                        else if (sender.html('لغو درخواست حذف'))
                            sender.html('درخواست حذف')

                    }
                });
            }
        }
    </script>
@endsection

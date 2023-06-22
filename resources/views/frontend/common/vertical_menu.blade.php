@php
$categories = App\Models\Category::orderBy('category_name', 'ASC')->get();
@endphp

<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
    <nav class="yamm megamenu-horizontal">
        <ul class="nav">

            @foreach($categories as $category)
            <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="{{ $category->category_icon }}" aria-hidden="true"></i>{{ $category->category_name }}</a>
                <ul class="dropdown-menu mega-menu">
                    <li class="yamm-content">
                        <div class="row">
                            @php
                            $subcategories = App\Models\SubCategory::where('category_id', $category->id)->orderby('subcategory_name', 'ASC')->get();
                            @endphp

                            @foreach($subcategories as $subcategory)
                            <div class="col-sm-12 col-md-3">
                                <a href="{{ url('subcategory/product/'.$subcategory->id.'/'.$subcategory->subcategory_slug ) }}">
                                    <h2 class="title">{{ $subcategory->subcategory_name }}</h2>
                                </a>
                                @php
                                $subsubcategories = App\Models\SubSubCategory::where('subcategory_id', $subcategory->id)->orderby('subsubcategory_name', 'ASC')->get();
                                @endphp

                                @foreach($subsubcategories as $subsubcategory)
                                <ul class="links list-unstyled">
                                    <li>
                                        <a href="{{ url('subsubcategory/product/'.$subsubcategory->id.'/'.$subsubcategory->subsubcategory_slug ) }}">
                                            {{ $subsubcategory->subsubcategory_name }}
                                        </a>
                                    </li>
                                </ul>
                                @endforeach
                            </div>
                            @endforeach
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- /.yamm-content -->
                </ul>
                <!-- /.dropdown-menu -->
            </li>
            <!-- /.menu-item -->
            @endforeach <!-- /.end-foreach-category -->
        </ul>
        <!-- /.nav -->
    </nav>
    <!-- /.megamenu-horizontal -->
</div>
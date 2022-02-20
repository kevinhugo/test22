<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{asset('css/googleapi.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

  <link rel="stylesheet" href="{{asset('open-iconic-master/font/css/open-iconic-bootstrap.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Test 2</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Hugo</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Item List
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Item</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Item</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Item List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="itemList" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                  </tfoot>
                </table>
                <button type="button" class="btn btn-success" id="addItem" style="float:right;">
                  Add Item
                </button>
                <div class="modal fade" id="itemModal">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title">Item</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                          <form id="itemForm" action="{{ route('item.save') }}" method="POST">
                            <input type="number" name="id" hidden>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Name</label>
                              <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Category</label>
                              <select class="form-control" name="category">
                                @foreach($categoryList as $eachCategory)
                                  <option value="{{$eachCategory['id']}}">{{$eachCategory['name']}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Description</label>
                              <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Image</label>
                              <div name="image-link-list">
                                <div class="input-group" name="image-link-row">
                                  <input type="text" name="image[0]" class="form-control" placeholder="Image link" aria-label="Image link" aria-describedby="basic-addon2">
                                  <div class="input-group-append">
                                    <button class="btn btn-outline-danger" name="delete-image-row" type="button"> <span class="oi oi-trash"></span> </button>
                                  </div>
                                </div>
                              </div>
                              <a href="#" id="addMoreImage">Add more</a>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Color</label>
                              <div name="color-list">
                                <div class="input-group" name="color-row">
                                  <input type="text" name="color[0]" class="form-control" placeholder="Color" aria-label="Color" aria-describedby="basic-addon2">
                                  <div class="input-group-append">
                                    <button class="btn btn-outline-danger" name="delete-color-row" type="button"> <span class="oi oi-trash"></span> </button>
                                  </div>
                                </div>
                              </div>
                              <a href="#" id="addMoreColor">Add more</a>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Size</label>
                              <div name="size-list">
                                <div class="input-group" name="size-row">
                                  <input type="text" name="size[0][size]" class="form-control" placeholder="Size" aria-label="Size" aria-describedby="basic-addon2">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                  </div>
                                  <input type="number" name="size[0][price]" class="form-control" placeholder="Price" aria-label="Size" aria-describedby="basic-addon2">
                                  <div class="input-group-append">
                                    <button class="btn btn-outline-danger" name="delete-size-row" type="button"> <span class="oi oi-trash"></span> </button>
                                  </div>
                                </div>
                              </div>
                              <a href="#" id="addMoreSize">Add more</a>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <div class="modal fade" id="deleteItemModal">
        <input type="number" name="delete-item-id" hidden>
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Confirmation Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure to delete this item ?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('dist/js/pages/dashboard.js')}}"></script> -->

<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
$(document).ready(function() {
    let itemListTable = $("#itemList").DataTable({
        searching: true,
        autoWidth: false,
        processing: true,
        serverSide: true,
        pageLength: 10,
        ajax: {
            url: "{{ route('item.get.item-list') }}",
            type: 'GET',
        },
        order: [],
        columns: [
            {
                data: 'name',
                name: 'name',
                orderable: true,
                searchable: true,
                defaultContent: "-"
            },
            {
                data: 'category',
                name: 'category',
                orderable: true,
                searchable: true,
                defaultContent: "-"
            },
            {
                data: 'description',
                name: 'description',
                orderable: true,
                searchable: true,
                defaultContent: "-"
            },
            {
                data: null,
                name: null,
                defaultContent: "-",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button type="button" item-id="${row.id}" class="btn btn-info" name="show-item-detail">
                          Edit
                        </button>
                        <button type="button" item-id="${row.id}" class="btn btn-danger" name="delete-item">
                          Delete
                        </button>
                    `;
                }
            },
        ],
        responsive: false
    });
    $("#itemList tfoot th:not(:last)").each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control search" name="' + title + '" />' );
    } );
    $("#itemList thead").append($("#itemList tfoot th"));

    $("#itemList_filter").css("visibility","hidden");

    itemListTable.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    let imageLinkList = $("div[name='image-link-list']");
    let colorList = $("div[name='color-list']");
    let sizeList = $("div[name='size-list']");
    let itemForm = $("form#itemForm");

    $(document).on("click","[name='delete-image-row']",function() {
      let imageLinkCount = imageLinkList.children().length;
      if(imageLinkCount <= 1) return;
      $(this).closest("div[name='image-link-row']").remove();
      reIndexImageLinkList();
    });

    $(document).on("click","#addMoreImage",function() {
      addImageLinkRow();
    });

    function addImageLinkRow() {
      let imageLinkCount = imageLinkList.children().length;
      imageLinkList.append(`
        <div class="input-group" name="image-link-row">
          <input type="text" name="image[${imageLinkCount}]" class="form-control" placeholder="Image link" aria-label="Image link" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-outline-danger" name="delete-image-row" type="button"> <span class="oi oi-trash"></span> </button>
          </div>
        </div>
      `);
    }

    function reIndexImageLinkList() {
      $.each(imageLinkList.children(),function(index,row) {
        row = $(row);
        row.find("input[name*='image']").attr("name",`image[${index}]`);
      });
    }

    /////////////
    
    $(document).on("click","[name='delete-color-row']",function() {
      let colorCount = colorList.children().length;
      if(colorCount <= 1) return;
      $(this).closest("div[name='color-row']").remove();
      reIndexColorList();
    });

    $(document).on("click","#addMoreColor",function() {
      addColorRow();
    });

    function addColorRow() {
      let colorCount = colorList.children().length;
      colorList.append(`
        <div class="input-group" name="color-row">
          <input type="text" name="color[${colorCount}]" class="form-control" placeholder="Color" aria-label="Image link" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-outline-danger" name="delete-color-row" type="button"> <span class="oi oi-trash"></span> </button>
          </div>
        </div>
      `);
    }

    function reIndexColorList() {
      $.each(colorList.children(),function(index,row) {
        row = $(row);
        row.find("input[name*='color']").attr("name",`color[${index}]`);
      });
    }

  /////////////

  $(document).on("click","[name='delete-size-row']",function() {
    let sizeCount = sizeList.children().length;
    if(sizeCount <= 1) return;
    $(this).closest("div[name='size-row']").remove();
    reIndexSizeList();
  });

  $(document).on("click","#addMoreSize",function() {
    addSizeRow();
  });

  function addSizeRow() {
    let sizeCount = sizeList.children().length;
    sizeList.append(`
      <div class="input-group" name="size-row">
        <input type="text" name="size[${sizeCount}][size]" class="form-control" placeholder="Size" aria-label="Size" aria-describedby="basic-addon2">
        <div class="input-group-prepend">
          <span class="input-group-text">Rp</span>
        </div>
        <input type="number" name="size[${sizeCount}][price]" class="form-control" placeholder="Price" aria-label="Size" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-danger" name="delete-size-row" type="button"> <span class="oi oi-trash"></span> </button>
        </div>
      </div>
    `);
  }

  function reIndexSizeList() {
    $.each(sizeList.children(),function(index,row) {
      row = $(row);
      row.find("input[name*='[size]']").attr("name",`size[${index}][size]`);
      row.find("input[name*='[price]']").attr("name",`size[${index}][price]`);
    });
  }

  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  var itemModal = $("#itemModal");
  var deleteItemModal = $("#deleteItemModal");
  
  itemForm.on("submit", function (event)
  {
      event.preventDefault();
      let data = $(this).serializeArray();
      data["_token"] = "{{ csrf_token() }}";
      $.ajax({
          url: $(this).attr("action"),
          type: "POST",
          data: data,
          dataType: 'JSON',
          success: function (result) {
            Toast.fire({
              icon: 'success',
              title: result["message"]
            });
            itemModal.modal("hide");
            itemListTable.ajax.reload();
            clearModal();
          },
          error: function(result) {
            result = result["responseJSON"];
            Toast.fire({
              icon: 'error',
              title: result["message"]
            });
          }
      });
  });

  $(document).on("click","button[name='show-item-detail']",function() {
      $.ajax({
          url: "{{ route('item.detail') }}",
          type: "GET",
          data: { "id" : $(this).attr("item-id") },
          dataType: 'JSON',
          success: function (result) {
            //Modal handling
            clearModal();
            imageLinkList.html("");
            colorList.html("");
            sizeList.html("");
            //End of modal handling

            itemModal.modal("show");
            itemForm.find("input[name='id']").val(result["id"]);
            itemForm.find("input[name='name']").val(result["name"]);
            itemForm.find("select[name='category']").val(result["category_id"]);
            itemForm.find("textarea[name='description']").val(result["description"]);

            $.each(result["item_pictures"],function(index,row) {
              addImageLinkRow();
              let latestRow = imageLinkList.children().last();
              latestRow.find("input[name*='image']").val(row["link"]);
            });
            
            $.each(result["item_colors"],function(index,row) {
              addColorRow();
              let latestRow = colorList.children().last();
              latestRow.find("input[name*='color']").val(row["color"]);
            });
            
            $.each(result["item_sizes"],function(index,row) {
              addSizeRow();
              let latestRow = sizeList.children().last();
              latestRow.find("input[name*='[size]']").val(row["size"]);
              latestRow.find("input[name*='[price]']").val(row["price"]);
            });
            
            //Another Modal handling
            if(imageLinkList.children().length == 0) {
              addImageLinkRow();
            }
            if(colorList.children().length == 0) {
              addColorRow();
            }
            if(sizeList.children().length == 0) {
              addSizeRow();
            }
            //End of Another Modal handling
          },
      });
  });

  function clearModal() {
    itemForm.find("input[name='id']").val("");
    itemForm.find("input[name='name']").val("");
    itemForm.find("textarea[name='description']").val("");
    imageLinkList.html("");
    colorList.html("");
    sizeList.html("");

    addImageLinkRow();
    addColorRow();
    addSizeRow();
  }

  $("#saveButton").on("click",function() {
    itemForm.submit();
  });

  $("#addItem").on("click",function() {
    clearModal();
    itemModal.modal("show");
  });
  
  $(document).on("click","button[name='delete-item']",function() {
    deleteItemModal.find("input[name='delete-item-id']").val($(this).attr("item-id"));
    deleteItemModal.modal("show");
  });
  
  deleteItemModal.find("button#confirmDeleteButton").on("click",function() {
    $.ajax({
      url: "{{ route('item.delete.item') }}",
      type: "POST",
      data: { "id" : deleteItemModal.find("input[name='delete-item-id']").val() },
      dataType: 'JSON',
      success: function (result) {
        Toast.fire({
          icon: 'success',
          title: result["message"]
        });
        deleteItemModal.modal("hide");
        itemListTable.ajax.reload();
      },
      error: function(result) {
        result = result["responseJSON"];
        Toast.fire({
          icon: 'error',
          title: result["message"]
        });
      }
    });
  });
});
</script>
</body>
</html>


@include('components.Head')

<body>
    <x-navbar />
    <!-- New Content -->
    <div class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <img src="{{ asset('/build/images/ttl.svg') }}" alt="">
                        </div>

                        <div class="clearfix"></div>
                        
                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="{{ asset('/build/images/img.jpg') }}" alt="..."
                                    class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2>John Doe</h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                       
                        @include('layouts.sidebar')


                    </div>
                </div>

                @include('layouts.nav')
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                          
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 ">
                                <div class="x_panel">
                                    <div class="x_title">
                                       
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                       
<!-- viewCandidates.blade.php -->

<!-- <div class="container"> -->
  <div class="text-center">

    <h1>No Candidates Found</h1>
    <p>We're sorry, but no candidates were found for this event.</p>
  </div>
  <!-- <a href="#" class="button">Go Back</a>
</div> -->


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modal-container">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body" id="qrcode_data">
                        <p>Modal body text goes here.</p>
                    </div>

                </div>
            </div>
        </div>
        @include('components.Scripts')
    </div>
    <script>
         var csrfToken = '{{ csrf_token() }}';
    $(document).ready(function() {
        $(document).on("click", ".open-modal", function() {
            var id = $(this).attr("data");
            
            //console.warn(id);
            $.ajax({
                url: "{{ route('generate.qr.code') }}",
                type: 'POST',
                data: {
                    'event_id': id,
                    '_token': csrfToken
                }, // Convert the data to JSON string
                success: function(response) {
                    $('#modal-container').modal('show');
                    $("#qrcode_data").html(response);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
        });
    });
    
    $(document).ready(function() {
        var table = $('#event_table').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 7, 8, 9]
            }],
            "bProcessing": true,
            "bServerSide": true,
            "aaSorting": [
                [4, "desc"]
            ],
            "sPaginationType": "full_numbers",
            "sAjaxSource": "{{ route('get.all.events') }}",
            "language": {
                "infoFiltered": "",
                "processing": "Loading. Please wait..."
            },
            "aLengthMenu": [
                [10, 50, 100, 500],
                [10, 50, 100, 500]
            ],
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "event_code",
                    "value": $("#event_code").val()
                });
                aoData.push({
                    "name": "event_name",
                    "value": $("#event_name").val()
                });
                aoData.push({
                    "name": "start_date",
                    "value": $("#start_date").val()
                });
                aoData.push({
                    "name": "end_date",
                    "value": $("#end_date").val()
                });
                aoData.push({
                    "name": "status",
                    "value": $("#status").val()
                });

            }
        });
        var objTable = table;
        /*$("#event_code, #event_name, #start_date, #end_date, #status").change(function() {
            objTable.draw();
        });
        */
        $("#apply_filters").click(function() {
            objTable.draw();
        });

       
    
    });
    </script>
    <style>
    .edit-action {
        display: flex;
        justify-content: center;
        gap: 10px;
        font-size: 20px;
    }

    .qr-code {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qr-code img {
        width: 50px;
        min-height: 50px;
    }

    .img-replace {
        display: inline-block;
        overflow: hidden;
        text-indent: 100%;
        color: transparent;
        white-space: nowrap;
    }

    body,
    html {
        height: 100%;
        margin: 0;
    }

    .qr-code {
        display: flex;
        justify-content: center;
        align-items: center;
        /* margin-top: 50px; */
    }

    .qr-code img {
        width: 50px;
    }

    .qr-code.open-modal {
        /* Customize appearance as needed (e.g., cursor, display) */
        cursor: pointer;
        display: inline-block;
    }

    /* Styles for the hidden modal container */
    #modal-container {
        display: none;
        /* Initially hidden */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.4);
        /* Semi-transparent background */
        z-index: 999;
        /* Ensure modal is on top of other elements */
    }

    /* Styles for the modal window */
    .modal {
        position: absolute;
        /* top: 50%;
        left: 50%; */
        /* transform: translate(-50%, -50%); */
        background-color: white;
        z-index: 9999 !important;
        /* Customize background color */
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        /* Add rounded corners for a smoother look */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        /* Create depth and shadow */
    }

    /* Styles for the modal close button */
    .modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        border: none;
        background-color: red;
        /* Customize color */
        color: white;
        font-size: 16px;
        cursor: pointer;
        border-radius: 3px;
        /* Add rounded corners for the button */
    }
    </style>

</body>

</html>



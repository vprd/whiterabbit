<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/af-2.3.5/b-1.6.5/kt-2.5.3/r-2.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/af-2.3.5/b-1.6.5/kt-2.5.3/r-2.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>
</head>
<style>
    .tableContainer {
        width: 500px;
        margin-left: auto;
        margin-right: auto;

    }

    .tableContainer .actionPan {
        padding-bottom: 50px;
    }

    .file {
        visibility: hidden;
        position: absolute;
    }

    .uploadError {
        color: red;
    }

    .hide {
        display: none;
    }
</style>

<body>

    <div class="tableContainer">
        <div class="actionPan">
            <div class="form-group">
                <input type="file" name="file" class="file">
                <div class="input-group col-xs-12">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                    <input type="text" class="form-control input-lg" disabled placeholder="Upload Attachment">
                    <span class="input-group-btn">
                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                        <button class="upload btn btn-danger input-lg" type="button"><i class="glyphicon glyphicon-trash"></i> Upload</button>
                    </span>
                </div>
                <div class="uploadError"></div>
            </div>
            </td>
            </tr>

            <input type="button" id="DelButton" value="Delete Files" />
        </div>
        <table id="dirList" class="display" style="width:100%">
            <thead>
                <tr>
                    <th class="hide"></th>
                    <th>Name</th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list as $file) {
                ?>
                    <tr>
                        <td align="right" class="hide"> <input type="checkbox" name="user_checkbox" id="<?php echo $file['id']; ?>"> </td>
                        <td><?= $file['name'] ?></td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>


<script>
    $(document).ready(function() {
        var table = $('#dirList').dataTable();


        $('#dirList tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected');
            $(this).find('input[name="user_checkbox"]').prop("checked", !$(this).find('input[name="user_checkbox"]').prop("checked"));
        });


        $('#DelButton').click(function() {
            console.log();

            var files = [];
            $('input[name="user_checkbox"]:checked').each(function() {
                files.push($(this).attr('id'));
            });
            var r = confirm(files.length + ' file(s) will be deleted');
            if (r == true) {
                jQuery.ajax({
                    type: "POST",
                    url: "/dir/delete",
                    data: ({
                        files: files,
                    }),
                    success: function(resp) {
                        alert("Deleted!");
                        window.location.reload();

                    }
                });
            }
            // var r = confirm(dirtable.rows('.selected').data().length + ' file(s) selected');
            // if (r == true) {
            //     $.ajax({
            //         url: "/dir/delete",
            //         success: function(result) {
            //             $("#div1").html(result);
            //         }
            //     });
            // } else {

            // }
        });

        $(document).on('click', '.browse', function() {
            var file = $(this).parent().parent().parent().find('.file');
            file.trigger('click');
        });

        $(document).on('click', '.upload', function() {

            var jform = new FormData();
            jform.append('file', $('input[name="file"]').get(0).files[0]);
            $(this).val('Please wait ...');
            $.ajax({
                url: '/dir/upload',
                type: 'POST',
                data: jform,
                dataType: 'json',
                mimeType: 'multipart/form-data', // this too
                contentType: false,
                cache: false,
                processData: false,
                success: (data, status, jqXHR) => {
                    if (data.status == 'Success') {
                        alert(data.msg);
                        window.location.reload();
                    } else {
                        $(this).val("Upload");
                        $('.uploadError').html(data.msg);

                    }
                }
            });


            file.remove();
        });

        $(document).on('change', '.file', function() {
            $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });

    });
</script>
<div class="modal fade" id="" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
                <div class="form-msg"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="display:block; text-align:center;">Import <?php echo @$judul; ?></h3>
                <br>
                <form method="POST" action="<?php echo base_url($url); ?>" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <div class="input-group form-group">
                            <span class="input-group-addon" id="sizing-addon2">
                                <i class="glyphicon glyphicon-file"></i>
                            </span>
                            <input type="file" class="form-control" name="excel" aria-describedby="sizing-addon2">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <center><a href="<?php echo base_url($link); ?>" download="<?php echo @$filename; ?>"> Download Template Here </a></center>
                        <br>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-import"></i> Import Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
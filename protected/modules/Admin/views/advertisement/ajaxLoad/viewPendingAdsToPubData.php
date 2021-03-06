<div class="row details-cards">
    <div class="col s12">
        <?php
        foreach ($data as $value) {
            $designation = AdmDesignation::model()->findByPk($value->ref_designation_id);
            ?>
            <div class="card-panel expand-card detail-card outer-tb-15">
                <div class="row mb-0 expand-card-head">
                    <!--                    <div class="col s10">-->

                    <div class="col s2">
                        <h6 class="grey-text text-darken-1 "><?php echo $value->ad_reference; ?></h6>
                    </div>
                    <div class="col s4">
                        <h6 class="grey-text text-darken-1"><?php echo $value->ad_is_use_desig_as_title == 1 ? $designation->desig_name : $value->ad_title; ?></h6>
                    </div>
                    <div class="col s2">
                        <h6 class="grey-text text-darken-1"><?php echo $value->ad_expire_date ?></h6>
                    </div>
                    <div class="col s2">
                        <button class="border-r-0 btn waves-effect waves-light" id="<?php echo $value->ad_id; ?>"
                                onclick="viewAndPub(this.id)">View &AMP; Publish
                        </button>
                    </div>
                    <div class="col s2">
                        <button class="border-r-0 btn waves-effect waves-light deep-orange"
                                id="<?php echo $value->ad_id; ?>" onclick="Publish(this.id)">Publish
                        </button>
                    </div>

                    <!--                    </div>-->

                </div>
            </div>

            <?php
        }
        ?>
    </div>

    <div class="col s12">
        <div class="site-pagination">
            <?php
            Paginations::setLimit($limit);
            Paginations::setPage($currentPage);
            Paginations::setJSCallback("loadPendingAdsToPubData");
            Paginations::setTotalPages($pageCount);
            Paginations::makePagination();
            Paginations::drawPagination();
            ?>
        </div>
    </div>

</div>
<!--<ul class="pagination right">
    <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
    <li class="active"><a href="#!">1</a></li>
    <li class="waves-effect"><a href="#!">2</a></li>
    <li class="waves-effect"><a href="#!">3</a></li>
    <li class="waves-effect"><a href="#!">4</a></li>
    <li class="waves-effect"><a href="#!">5</a></li>
    <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
</ul>-->


<script>
    function viewAndPub(id) {
        Animation.load('body');
        window.location.href = '<?php echo Yii::app()->baseUrl . '/Admin/Advertisement/ViewPreviewAdToPub/id/'; ?>' + id;
    }

    function Publish(id) {
        Animation.load('body');
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Advertisement/PublishAdvertisement'; ?>",
            data: {id: id},
            dataType: 'json',
            success: function (responce) {
                if (responce.code == 200) {
                    loadPendingAdsToPubData(1);
                    Animation.hide();
                }
            }
        });
    }

    //Order edit
    $('.btn-editAndSave').on('click', function () {
        var $this = $(this);
        var input = $this.prev('input');
        if (input.is(':disabled')) {
            input.prop('disabled', false);
            $this.find('i').html('save');
        } else {
            input.prop('disabled', true);
            $this.find('i').html('edit');
        }
    });

</script>
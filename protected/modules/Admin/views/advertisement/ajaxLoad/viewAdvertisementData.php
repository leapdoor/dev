<div class="row details-cards">
    <div class="col s12">
        <?php
        foreach ($data as $value) {
            $designation = AdmDesignation::model()->findByPk($value->ref_designation_id);
            ?>
            <div class="card-panel expand-card detail-card outer-tb-15">
                <div class="row mb-0 expand-card-head">
                    <div class="col s11">
                        <div class="row mb-0">
                            <div class="col mt-5 s1 ps-relative">
                                <input value="12" type="text" disabled="disabled" class="disabled h-20">
                                <button class="cm-btn ps-absolute top-0 right-5 btn-editAndSave">
                                    <i class="material-icons m-0 red-text">edit</i>
                                </button>
                            </div>
                            <div class="col s3">
                                <h6 class="grey-text text-darken-1 "><?php echo $value->ad_reference; ?></h6>
                            </div>
                            <div class="col s4">
                                <h6 class="grey-text text-darken-1"><?php echo $value->ad_is_use_desig_as_title == 1 ? $designation->desig_name : $value->ad_title; ?></h6>
                            </div>
                            <div class="col s4">
                                <h6 class="grey-text text-darken-1"><?php echo $value->ad_expire_date ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col s1 mt-5 right-align">

                        <i id="<?php echo $value->ad_id; ?>" onclick="edit(this.id)"
                           class="material-icons m-0 red-text">edit</i>
                        <!--                        <button class="cm-btn right-5 " id="-->
                        <?php //echo $value->ad_id; ?><!--" onclick="edit(this.id)">-->
                        </button>
                        <!--                        <i id="<?php // echo $value->ad_id;             ?>" class="right material-icons btn_expand" onclick="edit(this.id)">expand_more</i>                        -->
                    </div>
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
            Paginations::setJSCallback("loadAdvertisementData");
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
    function edit(id) {
        Animation.load('body');
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Advertisement/EditAdvertisement'; ?>",
            data: {id: id},
            success: function (responce) {
                $('.addNew,.search-area,.details-cards').slideUp('fast', function () {
                    $(".ajaxLoadAdd").html(responce);
                    $('.company-form').slideDown('slow');
                    Animation.hide();
                })
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
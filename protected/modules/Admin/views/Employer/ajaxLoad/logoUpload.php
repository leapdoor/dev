<div class="row">
    <div class="col s12">
        <div class="col s12 mt-30">
            <h5 class="grey-text text-darken-1 center mb-15">Logo Upload</h5>
            <div class="image-editor">


                <div class="cropit-preview border-8 m-auto"></div>

                <div class="mt-15 file-uploader ds-block m-auto width-100 u-small mb-15">
                    <div class="button">Brows...</div>
                    <input type="file" class="cropit-image-input">
                </div>

                <div class="row mb-10">
                    <div class="col s6 push-s3">
                        <input type="range" min="0" max="100" value="1" data-rangeslider
                               class="rangeSlide cropit-image-zoom-input">
                    </div>

                    <div class="col s12">
                        <button type="button" class="waves-effect waves-light btn right export">Export</button>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>


<!--JS | Image Crop-->

<script src="<?php echo Yii::app()->baseUrl . '/js/lib/jquery.2.0.0.js'; ?>"></script>
<script src="<?php echo Yii::app()->baseUrl . '/js/plugins/cropit/jquery.cropit.js'; ?>"></script>


<script>


    $(function () {
        $('.image-editor').cropit({
            imageState: {
                src: './../images/system/other/212x114.png',
            },
            width: 212,
            height: 114,
            imageBackgroundBorderWidth: 15 // Width of background border
        });

        $('.export').click(function () {
            var imageData = $('.image-editor').cropit('export', {
                type: 'image/jpeg'
            });
            profileImage(imageData);

            (function ($) {
                $(function () {
                    $('#modal1').modal('close');
                })
            }(jQuery))
        });
    });
</script>
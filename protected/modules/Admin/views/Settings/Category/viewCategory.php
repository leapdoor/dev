<?php $form = $this->beginWidget('CActiveForm', array('id' => 'formAddCategory')); ?>
<div class="row">
    <div class="col s12">
        <div class="card ">
            <div class="card-content">
                <h5 class="grey-text text-darken-1">Add Category</h5>

                <div class="row">
                    <div class="col s12 m8">
                        <div class="input-field">
                            <input id="hiddenId" name="hiddenId" type="hidden" value="0" required>
                            <input id="name" name="name" type="text" required>
                            <label>Category Name</label>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            <input id="order" name="order" type="text" required>
                            <label>Category Order</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <button type="button" class="cm-btn add right add-new-input"><i class="material-icons left">
                                &#xE148;</i>Add
                            New
                        </button>
                    </div>
                </div>

                <div class="row row-input">
                    <div class="col s4 input-no-label">
                        <input id="hiddenSubCatId[]" name="hiddenSubCat[]" type="hidden" value="0" class="hiddenSubCat">
                        <input id="subCatId[]" name="subCatName[]" type="text" class="pr-20">
                        <button id="delSubCatId_0" class="cm-btn ps-absolute right-5 btn-delete-input">
                            <i class="material-icons m-0 red-text">delete</i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-action right-align">
                <button type="button" class=" btn waves-effect waves-light red lighten-1" onclick="clearCategory()">
                    Clear
                </button>
                <button id="saveCategory" type="submit" class="btn waves-effect waves-light blue lighten-1">Save
                </button>

            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<!--Data Showing area-->
<div class="ajaxLoad"></div>

<!-- ===========================================================================
        Custom Script
============================================================================ -->

<script>

    var i = 0;
    function buildInput(appendEle) {
        i = i + 1;
        //Clear old
        if (arguments[1]) {
            $(appendEle).html('');
        }

        var html = '';
        html += '<div class="col s4 input-no-label">';
        html += '<input type="hidden" id="hiddenSubCatId_' + i + '" name="hiddenSubCat[]" value="0" class="hiddenSubCat">';
        html += '<input type="text" id="subCatId_' + i + '" name="subCatName[]" class="pr-20">';
        html += '<button id="delSubCatId_0" class="cm-btn ps-absolute right-5 btn-delete-input">';
        html += '<i class="material-icons m-0 red-text">delete</i>';
        html += '</button>';
        html += '</div>';

        $(appendEle).append($(html));
        $('.input-no-label input[type="text"]').focus();
    }

    //Add new inputs
    $('.add-new-input').on('click', function () {
        buildInput('.row-input');
    });

    //Delete Input
    $(document).on('click', '.btn-delete-input', function () {
        var clickedId = this.id;
        var id = clickedId.split("_")[1];
        if (id > 0) {
            deleteSubCategory(id);
        }

        $(this).parents('.input-no-label').remove();
    });

    //Form clean
    $(document).on('click', '.btn-form-clean', function () {
        buildInput('.row-input', true);
        $('input').val('');
        $(document).ready(function () {
            Materialize.updateTextFields();
        });
    });


</script>

<!-- ===========================================================================
        Backend Script
============================================================================ -->
<script type="text/javascript">
    $(document).ready(function (e) {
        loadCategoryData();
    });

    function loadCategoryData() {
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Category/ViewCategoryData'; ?>",
            data: '',
            success: function (responce) {
                $(".ajaxLoad").html(responce);
            }
        });
    }

    $("#formAddCategory").validate({
        submitHandler: function () {
            SaveCategory();
        }
    });

    function SaveCategory() {
        Animation.load('body');
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Category/SaveCategory'; ?>",
            data: $('#formAddCategory').serialize(),
            dataType: 'json',
            success: function (responce) {
                if (responce.code == 200) {
                    Message.success(responce.msg);
                    $("#formAddCategory")[0].reset();
                    $('.pr-20').attr('value', '');
                    $('.row-input > .input-no-label').not(':first').remove();
                    loadCategoryData();
                    Animation.hide();s
                }
            }
        });
    }

    function loadDataToEdit(data) {

        //Update Text fields
        $(document).ready(function () {
            Materialize.updateTextFields();
            //page Scroll to up
            Scroll.toUp();
        });

        $("#formAddCategory")[0].reset();
        var categories = data.categoryData;
        var subCategories = data.subCategoryData;

        $('#hiddenId').val(categories.cat_id);
        $('#name').val(categories.cat_name);
        $('#order').val(categories.cat_order);

        if (subCategories.length > 0) {
            $('.row-input > .input-no-label').remove();
        } else {
            $('.pr-20').attr('value', '');
            $('.row-input > .input-no-label').not(':first').remove();
        }

        for (var i = 0, max = subCategories.length; i < max; i++) {
            var html = '';
            html += '<div class="col s4 input-no-label">';
            html += '<input type="hidden" id="hiddenSubCatId_' + i + '" name="hiddenSubCat[]" value="' + subCategories[i]['scat_id'] + '" class="hiddenSubCat">';
            html += '<input type="text" id="subCatId_' + i + '"  name="subCatName[]" value="' + subCategories[i]['scat_name'] + '" class="pr-20">';
            html += '<button id="delSubCatId_' + subCategories[i]['scat_id'] + '" class="cm-btn ps-absolute right-5 btn-delete-input">';
            html += '<i class="material-icons m-0 red-text">delete</i>';
            html += '</button>';
            html += '</div>';

            $('.row-input').append(html);
        }
    }

    function deleteSubCategory(id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Category/DeleteSubCategory'; ?>",
            data: {id: id},
            dataType: 'json',
            success: function (responce) {
                if (responce.code == 200) {
                    Message.success(responce.msg);
                }
            }
        });
    }

    function clearCategory() {
        $("#formAddCategory")[0].reset();
        $('.pr-20').attr('value', '');
        $('.row-input > .input-no-label').not(':first').remove();
        $(document).ready(function () {
            Materialize.updateTextFields();
        });
    }

</script>

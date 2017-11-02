<?php $form = $this->beginWidget('CActiveForm', array('id' => 'formAddPackages')); ?>
<div class="row">
    <div class="col s12">
        <div class="card ">
            <div class="card-content">
                <h5 class="grey-text text-darken-1">Packages</h5>

                <div class="row">
                    <div class="col s12 m8">
                        <div class="input-field">
                            <input id="hiddenId" name="hiddenId" type="hidden" value="0" required>
                            <input id="name" name="name" type="text" autocomplete="off" required>
                            <label>Package Name</label>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            <input id="amount" name="amount" type="text" autocomplete="off">
                            <label>Amount(LKR)</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s8 mt-40">
                        <div class="row">
                            <div class="col s4">
                                <h6 class="grey-text text-darken-1">Number of Advertisement/s</h6>
                            </div>
                            <div class="col s6">
                                <div class="row mb-0">
                                    <div class="col s4">
                                        <div class="input-no-label mt-0">
                                            <input id="noOfAds" name="noOfAds" autocomplete="off" class="mb-0 input-adv right-align" type="text">
                                        </div>
                                    </div>
                                    <div class="col s4">
                                        <input id="isUnlimited" name="isUnlimited" type="checkbox"  autocomplete="off" class="filled-in chb-unlimited" id="filled-in-box"/>
                                        <label for="filled-in-box">Unlimited</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="row">
                            <div class="col 4">
                                <div class="input-field">
                                    <select id="validity" name="validity" class="mb-0" required>
                                        <option value="" disabled selected>Choose Month</option>
                                        <?php for ($i = 1; $i <= 12; $i++) {
                                            ?>
                                            <option id="sel_<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <label>Validity Period</label>
                                </div>
                            </div>
                            <div class="col 4">
                                <h6 class="grey-text text-darken-1 mt-40">Months</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-action right-align">
                <button type="button" onclick="clearPackage()" class=" btn waves-effect waves-light red lighten-1 btnCleanForm">Clear</button>
                <button type="submit" class="btn waves-effect waves-light blue lighten-1">Save</button>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<div class="ajaxLoad"></div>



<!-- ===========================================================================
        Custom Script
============================================================================ -->
<script>
    $(document).ready(function () {
        $('select').material_select();

        advertisementLimit($('.chb-unlimited'));
    });

    $('.chb-unlimited').on('change', function () {
        advertisementLimit($(this));
    });

    function advertisementLimit(ele) {
        if ($(ele).is(':checked')) {
            $('.input-adv').prop('disabled', true).val('');
        } else {
            $('.input-adv').prop('disabled', false).focus();
        }
    }

    $(document).ready(function () {
        $('select').material_select();
    });

</script>

<!-- ===========================================================================
        Backend Script
============================================================================ -->
<script>
    $(document).ready(function (e) {
        loadPackagesData();
    });

    function loadPackagesData() {
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Package/ViewPackageData'; ?>",
            data: '',
            success: function (responce) {
                $(".ajaxLoad").html(responce);
            }
        });
    }

    $("#formAddPackages").validate({
        submitHandler: function () {
            SavePackage();
        }
    });

    function SavePackage() {
        Animation.load('body');


        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Package/SavePackage'; ?>",
            data: $('#formAddPackages').serialize(),
            dataType: 'json',
            success: function (responce) {
                if (responce.code == 200) {
                    Message.success(responce.msg);
                    $("#formAddPackages")[0].reset();
                    loadPackagesData();
                    Animation.hide();
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

        $("#formAddPackages")[0].reset();
        var packages = data.packageData;

        $('#hiddenId').val(packages.pack_id);
        $('#name').val(packages.pack_name);
        $('#amount').val(packages.pack_amount);
        $('#noOfAds').val(packages.pack_num_of_ads);

        if (packages.pack_is_unlimited == "on") {
            $('#isUnlimited').attr('checked', true);
        }

        //has to select the selected item {packages.pack_validity_period is the value}
    }

    function clearPackage() {
        $("#formAddPackages")[0].reset();
        $("#hiddenId").val('0');
    }

</script>
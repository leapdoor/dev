<?php
$mainLinks = AdmLinks::model()->findAllByAttributes(array('lnk_parent_id' => 0, 'lnk_is_module' => 0), array('order' => 'lnk_order ASC'));
?>

<div class="navbar-fixed">
    <nav class="nav-yellow">
        <div class="container">
            <div class="nav-wrapper">
                <a class="brand-logo logo-link" href="<?php echo Yii::app()->request->baseUrl . "/Admin/Default/Index"; ?>">
                    <img src="<?php echo Yii::app()->baseUrl . '/images/system/logo/logo.png'; ?>" alt="">
                </a>
                <ul class="hide-on-med-and-down right menu">
                    <?php
                    foreach ($mainLinks as $mainLink) {
                        ?>
                        <li>
                            <a><?php echo strtoupper($mainLink->lnk_name); ?>   </a>
                            <ul>
                                <?php
                                $subLinks = AdmLinks::model()->findAllByAttributes(array('lnk_parent_id' => $mainLink->lnk_id), array('order' => 'lnk_order ASC'));
                                foreach ($subLinks as $subLink) {
                                    if ($subLink->lnk_is_module == 1) {
                                        $subUrl = Yii::app()->request->baseUrl . '/' . $subLink->lnk_module . '/' . $subLink->lnk_controller . '/' . $subLink->lnk_action;
                                    } else {
                                        $subUrl = Yii::app()->request->baseUrl . '/' . $subLink->lnk_controller . '/' . $subLink->lnk_action;
                                    }
                                    ?>
                                    <li><a href="<?php echo $subUrl ?>"><?php echo $subLink->lnk_name; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>

                    <li><a href="<?php echo Yii::app()->request->baseUrl . '/Admin/Default/Logout' ?>">Sign Out</a> <li>
                </ul>

            </div>
        </div>
    </nav>
</div>




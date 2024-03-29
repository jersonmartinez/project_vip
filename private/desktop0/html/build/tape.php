<?php
    /**
        * --------------------------------------------- *
        * @author: Jerson A. Martínez M. (Side Master)  *
        * --------------------------------------------- *
    */
?>

<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-expand-toggle">
                <i class="fa fa-bars icon"></i>
            </button>
            <ol class="breadcrumb navbar-breadcrumb">
                <li class="active">VIP - PS 
                    <?php
                        if (@$_SESSION['privilege'] == "Administrador"){
                            ?>
                                | <b>Administración</b>
                            <?php
                        }
                    ?>
                </li>
            </ol>
            <img src="source/img/logo.png" class="img_logo_unanleon" alt="UNAN - León" title="Universidad Nacional Autónoma de Nicaragua (UNAN - León)" />
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-th icon"></i>
            </button>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-times icon"></i>
            </button>
            <li>
                <a href="#" onclick="javascript: GoMainNow();" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-home fa-2x" style="margin-right: 10px"></i>Página principal</a>
            </li>

            <?php
                $CN = CDB("vip");
                $QuantitySus = $CN->getActivityNotificationFavoritiesCount(@$_SESSION['usr']);
                $QuantityMsg = $CN->getActivityNotificationMessageCount(@$_SESSION['usr']);
                $QuantityTotal = $QuantitySus + $QuantityMsg;
            ?>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-comments-o fa-2x"></i></a>
                <ul class="dropdown-menu animated fadeInDown">
                    <li class="title" style="cursor: pointer;" onclick="CallModalActivityMessageMe();">
                        Notificaciones <span class="badge pull-right"><?php echo $QuantityTotal; ?></span>
                    </li>
                    <li class="message">
                        <?php
                            if ($QuantityTotal == 0){
                                ?>
                                    No hay nuevas notificaciones
                                <?php
                            } else {
                                ?>
                                    Hay notificaciones de mensaje
                                <?php
                            }
                        ?>
                    </li>
                </ul>
            </li>

            <li class="dropdown danger">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-star-half-o fa-2x"></i> <?php echo $QuantityTotal; ?></a>
                <ul class="dropdown-menu danger  animated fadeInDown">
                    <li class="title">
                        Notificaciones <span class="badge pull-right"><?php echo $QuantityTotal; ?></span>
                    </li>
                    <li>
                        <ul class="list-group notifications">
                            <a href="#" onclick="CallModalActivityFavorities();">
                                <li class="list-group-item" >
                                    <span class="badge"><?php echo $QuantitySus; ?></span> <i class="fa fa-star-half-o icon"></i> Actividades favoritas
                                </li>
                            </a>
                            <a href="#" onclick="CallModalActivityMessageMe();">
                                <li class="list-group-item">
                                    <span class="badge danger"><?php echo $QuantityMsg; ?></span> <i class="fa fa-comments icon"></i> Mensajes a mis actividades
                                </li>
                            </a>
                            <!-- <a href="#">
                                <li class="list-group-item message">
                                    Ver todo
                                </li>
                            </a> -->
                        </ul>
                    </li>
                </ul>
            </li>
            
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle dpd-menu-open" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user fa-2x" style="margin-right: 10px"></i><?php echo @$_SESSION['usr']; ?><span class="caret"></span></a>
                <ul class="dropdown-menu animated fadeInDown">
                    <li class="profile-img">
                       
                        <i class="fa fa-camera fa-2x icon-camera-change" onclick="javascript: OpenModalChangeIMG();" aria-hidden="true" title="Cambiar imagen de perfil"></i>

                        <div class="add_new_img_perfil">
                            <?php
                                $CN = CDB("vip");
                                $QImg = $CN->getUserImgPerfil(@$_SESSION['usr'], "DESC", 1);

                                if (is_array($QImg)){
                                    foreach ($QImg as $value) {
                                        ?>
                                            <img src="private/desktop0/<?php echo $value['folder'].$value['src']; ?>" class="profile-img" />
                                        <?php
                                    }
                                } else if (is_bool($QImg)) {
                                    ?>
                                        <img src="private/desktop0/img/img-default/bg_default.jpg" class="profile-img" />
                                    <?php
                                }
                            ?>
                        </div>
                    </li>
                    <li>
                        <div class="profile-info">
                            <h4 class="username">
                                <a href="#" onclick="javascript: ShowModalPersonalForm();" class="FirstnameAndLastname">
                                    <?php 
                                        $Firstname_Lastname = $CN->getUserFirstname_Lastname($_SESSION['usr']);
                                        if (is_bool($Firstname_Lastname) || $Firstname_Lastname == ""){
                                            echo @$_SESSION['usr'];
                                        } else {
                                            echo $Firstname_Lastname;
                                        }

                                        // echo @$_SESSION['usr']; 
                                    ?>
                                </a>
                            </h4>
                            <p id="pEmail_user"><?php echo $CN->getUserEmail(@$_SESSION['usr']); ?></p>
                            <div class="btn-group margin-bottom-2x" role="group">
                                <button type="button" class="btn btn-primary" onclick="javascript: MenuConfig();"><i class="fa fa-cogs"></i>Configuración</button>
                                <button type="button" onclick="javascript: window.location.href='private/desktop0/php/logout.php';" class="btn btn-default"><i class="fa fa-sign-out"></i>Cerrar sesión</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
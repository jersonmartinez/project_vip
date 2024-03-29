<?php
    /**
        * --------------------------------------------- *
        * @author: Jerson A. Martínez M. (Side Master)  *
        * --------------------------------------------- *
    */
?>

<input type="hidden" class="change-img_perfil" data-toggle="modal" data-target="#ChangeImgPerfil" />

<!-- Modal -->
<div class="modal fade modal-primary" id="ChangeImgPerfil" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-camera"></i> Agregar nueva imagen de perfil</h4>
            </div>
            <div class="modal-body">
                <form id="Form_SendImgPerfil" enctype="multipart/form-data">
                    <input type="file" name="imagen" onchange="javascript: upload_img_perfil();" />
                </form>
                <div class="show_img_perfil"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: ListenerClickOkImgPerfil();">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Este es para las opciones del artículo!. -->
<input type="hidden" class="WindowModalAboutTeamProject" data-toggle="modal" data-target="#WindowModalAboutTeamProject"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="WindowModalAboutTeamProject" tabindex="1" role="dialog" aria-labelledby="myWindowModalAboutTeamProject" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyArticleTitle"><i class="fa fa-cubes" aria-hidden="true"></i> Información del equipo</h4>
            </div>

            <div class="row">

                <div class="col-xs-4">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title showTitleTeamProject">Nombres y apellidos</h3>
                                    </div>
                                </div>

                                <div class="ShowInfoTeamProject">
                                    
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xs-8">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="panel panel-default" style="padding-bottom: 15px;">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><span class="icon fa fa-users"></span> Miembros del equipo <i class="fa fa-plus-circle buttons_addPanel" onclick="javascript: AddNewTeamMemberModal();" aria-hidden="true" title="Agregar nuevo integrante"></i></h3>
                                    </div>

                                    <div class="ShowInfoMembersTeamProject">
                                        
                                    </div>
                                </div>
                            
                                <form id="FormIDTeamMemberSend">
                                    <input type="hidden" id="InputTextIDTeamMemberSend" name="InputTextIDTeamMemberSend" value="" />
                                </form>

                                <form id="FormIDTeamCoordinateSend">
                                    <input type="hidden" id="InputTextCoordinateIdMember" name="InputTextCoordinateIdMember" value="" />
                                    <input type="hidden" id="InputTextMemberCBValue" name="InputTextMemberCBValue" value="" />
                                </form>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary" style="float: left;" onclick="javascript: ProjectResult();">Resultados</button> -->
                
                <button type="button" class="btn btn-danger" onclick="javascript: DelTeamComplete();">Eliminar</button>
                <!-- <button type="button" class="btn btn-info" onclick="javascript: UpdateListItemArt();">Actualizar</button> -->
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Mostrar una centinela, preguntando si realmente desea eliminar el equipo seleccionado!. -->
<input type="hidden" class="TeamProjectDelComplete" data-toggle="modal" data-target="#TeamProjectDelComplete"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="TeamProjectDelComplete" tabindex="1" role="dialog" aria-labelledby="myTeamProjectDelComplete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myTeamProjectDelComplete">Eliminar equipo</h4>
            </div>
            <div class="modal-body">
                <h4>¿Está seguro que desea eliminar el equipo?</h4>
                <hr>
                <p>¡Atención!, si elimina el equipo, lo miembros que lo conforman también serán eliminados.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="javascript: onClickDeleteTeamComplete();">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrando todos los miembros registrados!. -->
<input type="hidden" class="ShowingAllTeamCoordinators" data-toggle="modal" data-target="#ShowingAllTeamCoordinators"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ShowingAllTeamCoordinators" tabindex="1" role="dialog" aria-labelledby="myShowingAllTeamCoordinators" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myShowingAllTeamCoordinators">Coordinadores de equipos</h4>
            </div>
            <div class="modal-body">
                <div class="showingAllCoordinatorsTeam">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="javascript: WebPageTeam();" class="btn btn-primary" style="float: left;">Miembros</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar una centinela, preguntando si realmente desea eliminar el miembro del equipo!. -->
<input type="hidden" class="TeamProjectAreYouSureDeleting" data-toggle="modal" data-target="#TeamProjectAreYouSureDeleting"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="TeamProjectAreYouSureDeleting" tabindex="1" role="dialog" aria-labelledby="myTeamProjectAreYouSureDeleting" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myTeamProjectAreYouSureDeleting">Eliminar miembro</h4>
            </div>
            <div class="modal-body">
                <h4>¿Está seguro que desea eliminar el miembro de este equipo?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="javascript: onClickDeleteTeamMember();">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregar nuevo integrante, miembro del equipo.  -->
<input type="hidden" class="AddNewTeamMemberModal" data-toggle="modal" data-target="#AddNewTeamMemberModal"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="AddNewTeamMemberModal" tabindex="1" role="dialog" aria-labelledby="MyNewTeamMemberModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyNewTeamMemberModal"><i class="fa fa-user"></i> Agregar nuevo miembro</h4>
            </div>
            <div class="modal-body">
                
                <div class="panel tagcloud-widget">
                  <div class="panel-heading">
                    <span class="panel-icon">
                      <i class="fa fa-pencil"></i>
                    </span>
                    <span class="panel-title">Por favor, rellene todos los campos para crear un integrante.</span>
                  </div>
                  <div class="panel-body" style="height: 530px;">
                    
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="panel-heading">
                                <h3 class="panel-title showTitleTeamMemberProject">Identidad</h3>
                            </div>

                            <div class="ShowInfoTeamMemberProjectAdd">
                                
                            </div>

                        </div>
                        
                        <div class="col-xs-8" style="margin-bottom: 0;">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><span class="icon fa fa-info-circle"></span> Datos personales <!-- <i class="fa fa-plus-circle buttons_addPanel" onclick="javascript: AddNewTeamMemberModal();" aria-hidden="true" title="Agregar nuevo integrante"></i>--> </h3>
                                            </div>

                                            <div class="panel-body">
                                                <input type="text" class="form-control" id="id_team_member_firstname" placeholder="* Nombre(s)" onkeyup="javascript: ChgCharacterTitleFirstNameModal(this);" /><br/>
                                                <input type="text" class="form-control" id="id_team_member_lastname" placeholder="* Apellido(s)" onkeyup="javascript: ChgCharacterTitleLastNameModal(this);" /><br/>
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><span class="icon fa fa-cubes"></span> Académico <!-- <i class="fa fa-plus-circle buttons_addPanel" onclick="javascript: AddNewTeamMemberModal();" aria-hidden="true" title="Agregar nuevo integrante"></i>--> </h3>
                                            </div>

                                            <div class="panel-body">
                                                <input type="text" class="form-control" id="id_team_member_grado_academico" placeholder="* Grado académico" title="Seleccione el grado en la parte inferior izquierda de esta ventana" /><br/>
                                                <input type="text" class="form-control" id="id_team_member_dependencia_academica" placeholder="* Dependencia académica" /><br/>
                                                <input type="text" class="form-control" id="id_team_member_tipo_contratacion" placeholder="* Tipo de contratación" /><br/>
                                                <input type="text" class="form-control" id="id_team_member_hrs_semanales_dedicacion" placeholder="* Horas semanales de dedicación" /><br/>
                                            </div>
                                        </div>

                                        <form id="dataSendIDs">
                                            <input type="hidden" id="dataSendIDs_firstname" name="dataSendIDs_firstname" value="" />
                                            <input type="hidden" id="dataSendIDs_lastname" name="dataSendIDs_lastname" value="" />
                                            
                                            <input type="hidden" id="dataSendIDs_grado_academico" name="dataSendIDs_grado_academico" value="" />
                                            <input type="hidden" id="dataSendIDs_dependencia_academica" name="dataSendIDs_dependencia_academica" value="" />
                                            
                                            <input type="hidden" id="dataSendIDs_tipo_contratacion" name="dataSendIDs_tipo_contratacion" value="" />
                                            <input type="hidden" id="dataSendIDs_hrs_semanales_dedicacion" name="dataSendIDs_hrs_semanales_dedicacion" value="" />
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: addMemberToTeam();" data-dismiss="modal">¡Agregar!...</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar mensaje de que escriba en todos los campos de texto!. -->
<input type="hidden" class="TeamMemberValidationFields" data-toggle="modal" data-target="#TeamMemberValidationFields"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="TeamMemberValidationFields" tabindex="1" role="dialog" aria-labelledby="myTeamMemberValidationFields" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myTeamMemberValidationFields">Advertencia</h4>
            </div>
            <div class="modal-body">
                <h4>Por favor, rellene todos los campos.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: CloseMyModalOpenOtherModal()" data-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- This is the modal window of the agents. -->
<input type="hidden" class="add-agent-now" data-toggle="modal" data-target="#AddAgent"  />
<!-- Modal -->
<div class="modal fade modal-primary" onclick="javascript: ReloadAgentSelect();" id="AddAgent" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar agente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Nombres y apellidos</h3>
                            </div>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="id_names" placeholder="* Nombres" /><br/>
                                <input type="text" class="form-control" id="id_lastnames" placeholder="* Apellidos" />
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Email, Localidad & Descripción</h3>
                            </div>
                            <div class="panel-body">
                                <input type="email" class="form-control" id="id_email_address" placeholder="* Dirección de correo" /><br/>
                                <input type="text" class="form-control" id="id_location" placeholder="* Localidad" />
                                <br/><textarea class="form-control" rows="3" id="id_description" style="max-width: 237px;" placeholder="Escribir descripción..."></textarea>
                            </div>
                        </div>
                     </div>

                     <div class="col-xs-6">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Líneas de contacto</h3>
                            </div>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="id_phone_claro" placeholder="Nº de teléfono Claro" /><br/>
                                <input type="text" class="form-control" id="id_phone_movistar" placeholder="Nº de teléfono Movistar" />
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Imagen de perfil (Opcional)</h3>
                            </div>
                            <div class="panel-body">
                                <form id="NewForm_SendAgentImgPerfil" enctype="multipart/form-data">
                                    <input type="file" id="id_path_img" name="new_imagen" style="width: 200px;" onchange="javascript: upload_agent_img_perfil();" />
                                </form>
                                <div class="show_agent_img_perfil"></div>

                            </div>
                        </div>

                     </div>

                     <form id="AllDataAgents">
                         <input type="hidden" id="names" value="" name="names" />
                         <input type="hidden" id="lastnames" value="" name="lastnames" />

                         <input type="hidden" id="email_address" value="" name="email_address" />
                         <input type="hidden" id="location" value="" name="location" />
                         <input type="hidden" id="description" value="" name="description" />

                         <input type="hidden" id="phone_claro" value="" name="phone_claro" />
                         <input type="hidden" id="phone_movistar" value="" name="phone_movistar" />

                         <input type="hidden" id="path_img" name="path_img" />
                     </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="javascript: RegisterAgent();" class="btn btn-primary">Registrar agente</button>
            </div>
        </div>
    </div>
</div>


<!-- Este es para las opciones del agente!. -->
<input type="hidden" class="show-optionsAgent" data-toggle="modal" data-target="#ShowOptionsAgent"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ShowOptionsAgent" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyAgentNames"></h4>
            </div>

            <form id="ShowDataAgentByEmail">
                <input type="hidden" id="ValueAgentByEmail" name="ValueAgentByEmail" />
            </form>

            <div class="modal-body ContentDataAgent">
                <!-- Aquí es donde se escribe la información con la petición -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="javascript: CallWindowModalDeleteAgent();">Eliminar</button>
                <button type="button" class="btn btn-info" onclick="javascript: UpdateAgentNow();">Actualizar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregar un nuevo equipo -->
<input type="hidden" class="createNewTeam" data-toggle="modal" data-target="#createNewTeam"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="createNewTeam" tabindex="1" role="dialog" aria-labelledby="myNewTeam" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myNewTeam"><span class="icon fa fa-users"></span> <label id="TitleNewTeamProject">Nuevo equipo</labeel></h4>
            </div>
            <div class="modal-body">
                <span class="panel-icon">
                  <i class="fa fa-pencil"></i>
                </span>
                <span class="panel-title">Escriba el nombre del equipo que desea crear.</span><br/><br/>
                
                <div class="row">
                    <form id="FormTeamProject">
                        <div class="col-xs-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ID del proyecto
                                    <i class="fa fa-plus-circle buttons_addPanel" onclick="javascript: window.location.href='./project';" aria-hidden="true" title="Agregar un nuevo proyecto" ></i></h3>
                                </div>
                                <div class="panel-body">
                                    <div>
                                        <input type="text" class="form-control" id="IDProjectNoSend" name="IDProjectNoSend" placeholder="[ID del proyecto]... " disabled/>
                                        <input type="hidden" class="form-control" id="IDProject" name="IDProject" placeholder="[ID del proyecto]... "/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Nombre del equipo
                                    <!-- <i class="fa fa-plus-circle buttons_addPanel" onclick="javascript: AddNewFacCurEsc();" aria-hidden="true" title="Agregar Facultad | CUR | Escuela" ></i></h3> -->
                                </div>
                                <div class="panel-body">
                                    <div>
                                        <input type="text" class="form-control" id="TeamName" name="TeamName" onkeyup="ChgCharacterTitleModal(this)" placeholder="[Nombre del equipo]... " />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: SaveCreateTeam();">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar mensaje de que escriba algo en el campo de texto!. -->
<input type="hidden" class="TeamProjectSuccessfull" data-toggle="modal" data-target="#TeamProjectSuccessfull"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="TeamProjectSuccessfull" tabindex="1" role="dialog" aria-labelledby="myTeamProjectSuccessfull" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myTeamProjectSuccessfull"></h4>
            </div>
            <div class="modal-body">
                <h4>El equipo ha sido creado con éxito. Haga click en cerrar.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: window.location.reload();" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar mensaje de que escriba algo en el campo de texto!. -->
<input type="hidden" class="TeamProjectProblem" data-toggle="modal" data-target="#TeamProjectProblem"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="TeamProjectProblem" tabindex="1" role="dialog" aria-labelledby="myTeamProjectProblem" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myTeamProjectProblem"></h4>
            </div>
            <div class="modal-body">
                <h4>¡Up's!. Lo lamentamos, el equipo no ha podido ser creado, por favor, recargue e intente nuevamente.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar mensaje de que escriba algo en el campo de texto!. -->
<input type="hidden" class="TeamProjectFailure" data-toggle="modal" data-target="#TeamProjectFailure"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="TeamProjectFailure" tabindex="1" role="dialog" aria-labelledby="myTeamProjectFailure" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myTeamProjectFailure"></h4>
            </div>
            <div class="modal-body">
                <h4>¡Up's!. Por favor, escriba el nombre del grupo antes de intentar guardar.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Entiendo</button>
            </div>
        </div>
    </div>
</div>

<!-- ¿Está seguro que desea eliminar el elemento? -->
<input type="hidden" class="deleteAgentmodal" data-toggle="modal" data-target="#DeleteAgentModal"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="DeleteAgentModal" tabindex="1" role="dialog" aria-labelledby="myModalLabelDeleteAgent" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelDeleteAgent">Eliminar agente</h4>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea eliminar el Agente?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="javascript: DeleteAgent();">Sí</button>
            </div>
        </div>
    </div>
</div>

<!-- Artículo agregado con éxito!. -->
<input type="hidden" class="ProjectResultFailure" data-toggle="modal" data-target="#ProjectResultFailure"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ProjectResultFailure" tabindex="1" role="dialog" aria-labelledby="ProjectResultFailureOK" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ProjectResultFailureOK"></h4>
            </div>
            <div class="modal-body">
                <h4>¡Up's!. Algo ha salido mal. El reporte del proyecto no se ha podido agregar. Recargue e intente nuevamente.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: window.location.href='./projects';" data-dismiss="modal">Recargar</button>
            </div>
        </div>
    </div>
</div>

<!-- Artículo agregado con éxito!. -->
<input type="hidden" class="ProjectResultSuccessfull" data-toggle="modal" data-target="#ProjectResultSuccessfull"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ProjectResultSuccessfull" tabindex="1" role="dialog" aria-labelledby="OKProjectResultSuccessfull" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="OKProjectResultSuccessfull"></h4>
            </div>
            <div class="modal-body">
                <h4>El reporte del proyecto se ha registrado con éxito.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: window.location.href='./projects';" data-dismiss="modal">¡OK!...</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregar resultados de un proyecto -->
<input type="hidden" class="AddResultProject" data-toggle="modal" data-target="#AddResultProject"  />

<!-- Modal -->
<div class="modal fade modal-primary" onclick="javascript: TransportCKEditor();" id="AddResultProject" tabindex="1" role="dialog" aria-labelledby="myAddResultProject" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myAddResultProject">Reporte final del proyecto</h4>
            </div>
            <div class="modal-body">
                <p>Redacte el reporte final sobre los resultados obtenidos en el proyecto.</p>
                 <div class="CKEditorProjectResult">
                     
                 </div>
                    
                <form id="FormProjectResult">
                    <input type="hidden" id="idp_result" name="idp_result" />
                    <input type="hidden" id="fpr_content" name="fpr_content" />
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript: TransportCKEditor();">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: UpdateResultProject();">Guardar</button>
            </div>
        </div>
    </div>
</div>


<!-- Opciones de la imagen seleccionada!. -->
<input type="hidden" class="ImgSelectedOptions" data-toggle="modal" data-target="#ImgSelectedOptions"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ImgSelectedOptions" tabindex="1" role="dialog" aria-labelledby="MyImgSelectedOptions" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyImgSelectedOptions"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Vista previa</h3>
                            </div>
                            <div class="panel-body">
                                <img id="ImgAmplia" src="" />
                            </div>
                        </div>
                     </div>
                </div>
            </div>

            <form id="NameImgToDelete">
                <input type="hidden" id="MyNameImgDelete" name="MyNameImgDelete" />
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="javascript: DeleteImgWriteArticle();">Eliminar</button>
                 <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Artículo agregado con éxito!. -->
<input type="hidden" class="InfoArtAddYes" data-toggle="modal" data-target="#InfoArtAddYes"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="InfoArtAddYes" tabindex="1" role="dialog" aria-labelledby="MyInfoArtAddYes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyInfoArtAddYes"></h4>
            </div>
            <div class="modal-body">
                <h4>El proyecto se ha registrado con éxito.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: window.location.href='./projects';" data-dismiss="modal">¡OK!...</button>
            </div>
        </div>
    </div>
</div>

<!-- Rellene todos los campos!. -->
<input type="hidden" class="RelleneTodosLosDatos" data-toggle="modal" data-target="#RelleneTodosLosDatos"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="RelleneTodosLosDatos" tabindex="1" role="dialog" aria-labelledby="MyRelleneTodosLosDatos" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyRelleneTodosLosDatos">Datos incompletos.</h4>
            </div>
            <div class="modal-body">
                <p>Algunos campos del formulario se encuentran vacíos, al menos los que son obligatorios (*). Por favor, rellene los campos y vuelva a intentarlo.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">¡Verificaré!...</button>
            </div>
        </div>
    </div>
</div>


<!-- Agregar nueva Comunidad | Población.  -->
<input type="hidden" class="AddNewComunidadPoblacion" data-toggle="modal" data-target="#AddNewComunidadPoblacion"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="AddNewComunidadPoblacion" tabindex="1" role="dialog" aria-labelledby="MyNewComunidadPoblacion" onclick="javascript: getComunidadPoblacion();" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyNewComunidadPoblacion"><i class="fa fa-map-marker"></i> Agregar Comunidad | Población</h4>
            </div>
            <div class="modal-body">
                
                <div class="panel tagcloud-widget">
                  <div class="panel-heading">
                    <span class="panel-icon">
                      <i class="fa fa-pencil"></i>
                    </span>
                    <span class="panel-title">Escriba el nombre de la comunidad o población. Presione Enter para guardar.</span>
                  </div>
                  <div class="panel-body">
                    <form id="SendDataComunidadPoblacion">
                        <input type="text" class="form-control" name="writeComunidadPoblacion" id="writeComunidadPoblacion" placeholder="Escriba aquí..." />
                    </form>
                    <div class="setDataComunidadPoblacion">
                       <?php
                            $CNEx = CDB("vip");

                            if (is_array($CNEx->getProjectComunidadPoblacion())){
                                foreach ($CNEx->getProjectComunidadPoblacion() as $value) {
                                    ?>
                                        <span class="label label-primary" style="font-size: 16px; background-color: #353D47; text-align: left; padding:10px; width:47.5%; margin: 10px 10px 0 0; display: inline-table;" ><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <?php 
                                                $NombreMunicipio = trim($value['nombre_muni']);
                                                if (iconv_strlen($NombreMunicipio) >= 20){
                                                    $NombreMunicipio = substr($NombreMunicipio, 0, 20)."...";
                                                }

                                                echo $NombreMunicipio;
                                            ?>
                                            <i class="fa fa-times" style="margin: -15px 5px 10px 0px; float: right; cursor: pointer;" title="Eliminar <?php echo $value['nombre_muni']; ?>" aria-hidden="true" onclick="javascript: DeleteTagComunidadPoblacion('<?php echo $value['cod_muni'] ?>');" ></i>
                                        </span>
                                    <?php
                                }
                            } else if (is_bool($CNEx->getProjectComunidadPoblacion())){
                                #Opcional para agregar un diálogo.
                            }
                        ?>
                    </div>

                    <form id="SendDataDeleteComunidadPoblacion">
                        <input type="hidden" class="form-control" name="DelTagComunidadPoblacion" id="DelTagComunidadPoblacion" />
                    </form>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: getComunidadPoblacion();" data-dismiss="modal">¡Okay!...</button>
            </div>
        </div>
    </div>
</div>


<!-- Agregar nueva Facultad | CUR | Escuela.  -->
<input type="hidden" class="AddNewFacCurEsc" data-toggle="modal" data-target="#AddNewFacCurEsc"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="AddNewFacCurEsc" tabindex="1" role="dialog" aria-labelledby="MyNewFacCurEsc" onclick="javascript: getFacCurEsc();" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyNewFacCurEsc"><i class="fa fa-pencil"></i> Agregar Facultad | Cur | Escuela</h4>
            </div>
            <div class="modal-body">
                
                <div class="panel tagcloud-widget">
                  <div class="panel-heading">
                    <span class="panel-icon">
                      <i class="fa fa-pencil"></i>
                    </span>
                    <span class="panel-title">Escriba el nombre de la facultad. Presione Enter para guardar.</span>
                  </div>
                  <div class="panel-body">
                    <form id="SendDataFacCurEsc">
                        <input type="text" class="form-control" name="writeFacCutEsc" id="writeFacCutEsc" placeholder="Escriba aquí..." />
                    </form>
                    <div class="setDataFacCurEsc">
                       <?php
                            $CNEx = CDB("vip");

                            if (is_array($CNEx->getProjectFacCurEsc())){
                                foreach ($CNEx->getProjectFacCurEsc() as $value) {
                                    ?>
                                        <span class="label label-primary" style="font-size: 16px; background-color: #353D47; text-align: left; padding:10px; width:100%; margin: 10px 10px 0 0; display: inline-table;" ><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                            <?php echo $value['nombrefac']; ?>
                                            <i class="fa fa-times" style="margin: 0 5px; position: absolute; right: 8%; cursor: pointer;" title="Eliminar <?php echo $value['nombrefac']; ?>" aria-hidden="true" onclick="javascript: DeleteTagFacCurEsc('<?php echo $value['codigo_facultad'] ?>');" ></i>
                                        </span>
                                    <?php
                                }
                            } else if (is_bool($CNEx->getProjectFacCurEsc())){
                                #Opcional para agregar un diálogo.
                            }
                        ?>
                    </div>

                    <form id="SendDataDeleteFacCurEsc">
                        <input type="hidden" class="form-control" name="DelTagFacCurEsc" id="DelTagFacCurEsc" />
                    </form>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: getFacCurEsc();" data-dismiss="modal">¡Okay!...</button>
            </div>
        </div>
    </div>
</div>


<!-- Agregar nueva instancia de aprobación. -->
<input type="hidden" class="AddNewInstanciaAprobacion" data-toggle="modal" data-target="#AddNewInstanciaAprobacion"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="AddNewInstanciaAprobacion" tabindex="1" role="dialog" aria-labelledby="MyNewInstanciaAprobacion" onclick="javascript: getInstanciaAprobacion();" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyNewInstanciaAprobacion"><i class="fa fa-briefcase" aria-hidden="true"></i> Agregar instancia de aprobación</h4>
            </div>
            <div class="modal-body">
                
                <div class="panel tagcloud-widget">
                  <div class="panel-heading">
                    <span class="panel-icon">
                      <i class="fa fa-pencil"></i>
                    </span>
                    <span class="panel-title">Escriba el nombre de la instancia. Presione Enter para guardar.</span>
                  </div>
                  <div class="panel-body">
                    <form id="SendDataInstanciaAprobacion">
                        <input type="text" class="form-control" name="writeInstanciaAprobacion" id="writeInstanciaAprobacion" placeholder="Escriba aquí..." />
                    </form>
                    <div class="setDataInstanciaAprobacion">
                       <?php
                            $CNEx = CDB("vip");

                            if (is_array($CNEx->getProjectInstanciaAprobacion())){
                                foreach ($CNEx->getProjectInstanciaAprobacion() as $value) {
                                    ?>
                                        <span class="label label-primary" style="font-size: 16px; background-color: #353D47; text-align: left; padding:10px; width:47.5%; margin: 10px 10px 0 0; display: inline-table;" ><i class="fa fa-briefcase" aria-hidden="true"></i>
                                            <?php 
                                                $NombreInstanciaAprobacion = trim($value['nombre_instancia_aprobacion']);
                                                if (iconv_strlen($NombreInstanciaAprobacion) >= 20){
                                                    $NombreInstanciaAprobacion = substr($NombreInstanciaAprobacion, 0, 20)."...";
                                                }

                                                echo $NombreInstanciaAprobacion;
                                            ?>
                                            <i class="fa fa-times" style="margin: -15px 5px 10px 0px; float: right; cursor: pointer;" title="Eliminar <?php echo $value['nombre_instancia_aprobacion']; ?>" aria-hidden="true" onclick="javascript: DeleteTagInstanciaAprobacion('<?php echo $value['id'] ?>');" ></i>
                                        </span>
                                    <?php
                                }
                            } else if (is_bool($CNEx->getProjectInstanciaAprobacion())){
                                #Opcional para agregar un diálogo.
                            }
                        ?>
                    </div>

                    <form id="SendDataDeleteInstanciaAprobacion">
                        <input type="hidden" class="form-control" name="DelTagInstanciaAprobacion" id="DelTagInstanciaAprobacion" />
                    </form>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: getInstanciaAprobacion();" data-dismiss="modal">¡Okay!...</button>
            </div>
        </div>
    </div>
</div>


<!-- Agregar nuevo tipo de propiedad. -->
<input type="hidden" class="AddNewTypePropertyNow" data-toggle="modal" data-target="#AddNewTypePropertyNow"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="AddNewTypePropertyNow" tabindex="1" role="dialog" aria-labelledby="MyAddNewTypePropertyNow" onclick="javascript: getPropiertyTypeBox();" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyAddNewTypePropertyNow">Agregar tipo de propiedad</h4>
            </div>
            <div class="modal-body">
                
                <div class="panel tagcloud-widget">
                  <div class="panel-heading">
                    <span class="panel-icon">
                      <i class="fa fa-pencil"></i>
                    </span>
                    <span class="panel-title">Después de escribir la categoría, presione Enter para guardar.</span>
                  </div>
                  <div class="panel-body">
                    <form id="SendDataTagPropertyType">
                        <input type="text" class="form-control" name="writeTagProperty_type" id="writeTagProperty_type" placeholder="Escriba aquí..." />
                    </form>
                    <div class="setDataTagPropertyType">
                       <?php
                            $getObjAddPT = $Conexion->query("SELECT * FROM property_type;");

                            if ($getObjAddPT->num_rows > 0){
                                while ($getDataPTAdd = $getObjAddPT->fetch_array(MYSQLI_ASSOC)){
                                    ?>
                                        <span class="label label-primary" style="font-size: 16px; margin: 10px 10px 0 0; display: inline-table;" ><?php echo $getDataPTAdd['name_type']; ?>

                                            <i class="fa fa-times" style="margin: 0 5px; cursor: pointer;" title="Eliminar" aria-hidden="true" onclick="javascript: DeleteTagPropertyType('<?php echo $getDataPTAdd['id'] ?>');" ></i>
                                        </span>
                                    <?php
                                }
                            }
                        ?>
                    </div>

                    <form id="SendDataDeletePropertyType">
                        <input type="hidden" class="form-control" name="DelTagPT" id="DelTagPT" />
                    </form>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: getPropiertyTypeBox();" data-dismiss="modal">¡Okay!...</button>
            </div>
        </div>
    </div>
</div>


<!-- Este es para las opciones del artículo!. -->
<input type="hidden" class="show-optionsArticle" data-toggle="modal" data-target="#ShowOptionsArticle"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ShowOptionsArticle" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyArticleTitle">Información del proyecto</h4>
            </div>

            <div class="row">

                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="step card-no-padding">
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li role="step" class="active step-success">
                                        <a href="#step1-2" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                            <div class="icon fa fa-pencil"></div>
                                            <div class="step-title">
                                                <div class="title">Redacción</div>
                                                <div class="description">Objetivos y resultados del proyecto.</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li role="step">
                                        <a href="#step2-2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                            <div class="icon fa fa-picture-o"></div>
                                            <div class="step-title">
                                                <div class="title">Mis imágenes</div>
                                                <div class="description">Recursos del proyecto...</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li role="step">
                                        <a href="#step3-2" role="tab" id="step3-tab" data-toggle="tab" aria-controls="profile">
                                            <div class="icon fa fa-tasks"></div>
                                            <div class="step-title">
                                                <div class="title">Información de formato</div>
                                                <div class="description">Facultad, CUR, Escuela, Código dictamen, etc.</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="step1-2" aria-labelledby="home-tab">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Redacción</h3>
                                            </div>
                                            <div class="panel-body">
                                                <input type="text" class="form-control" id="InsertTitleArticle" placeholder="Título del artículo..." />
                                                <div class="containerCKeditorProject">
                                                    <?php include ("private/desktop0/html/edit/index.html"); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="step2-2" aria-labelledby="profile-tab">
                                        <div class="mensage"></div>
                                        <table align="center">
                                            <tr>
                                                 <td><input type="file" multiple="multiple" id="archivos" onchange="javascript: UploadPhotos();"></td><!-- Este es nuestro campo input File -->
                                            </tr> 
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="step3-2" aria-labelledby="dropdown1-tab">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <form id="ShowDataArticleByID">
                <input type="hidden" id="ValueArticleByID" name="ValueArticleByID" />
            </form>

            <form id="SendAllDataUpdateArt">
                <input type="hidden" class="form-control" id="pro_id_project" name="pro_id_project" />

                <input type="hidden" class="form-control" id="pro_title" name="pro_title" />
                <textarea id="pro_content" style="display: none;" name="pro_content"></textarea>
                
                <input type="hidden" class="form-control" id="pro_fac_cur_esc" name="pro_fac_cur_esc" />
                <input type="hidden" class="form-control" id="pro_instancia_aprobacion" name="pro_instancia_aprobacion" />
                <input type="hidden" class="form-control" id="pro_comunidad_poblacion" name="pro_comunidad_poblacion" />
                
                <input type="hidden" class="form-control" id="pro_duracion_meses" name="pro_duracion_meses" />
                <input type="hidden" class="form-control" id="pro_fecha_aprobacion" name="pro_fecha_aprobacion" />
                <input type="hidden" class="form-control" id="pro_fecha_inicio" name="pro_fecha_inicio" />
                <input type="hidden" class="form-control" id="pro_fecha_finalizacion" name="pro_fecha_finalizacion" />
                <input type="hidden" class="form-control" id="pro_fecha_monitoreo" name="pro_fecha_monitoreo" />
                
                <input type="hidden" class="form-control" id="pro_nombre_organismo" name="pro_nombre_organismo" />
                <input type="hidden" class="form-control" id="pro_monto_financiado" name="pro_monto_financiado" />
                <input type="hidden" class="form-control" id="pro_aporte_unan" name="pro_aporte_unan" />
                <input type="hidden" class="form-control" id="pro_moneda" name="pro_moneda" /><br/>
                
                <input type="hidden" class="form-control" id="pro_zona_geografica" name="pro_zona_geografica" />
                
                <input type="hidden" class="form-control" id="pro_cod_dictamen" name="pro_cod_dictamen" />
                
                <input type="hidden" class="form-control" id="pro_tipo_publicacion" name="pro_tipo_publicacion" />
                <input type="hidden" class="form-control" id="pro_datos_publicacion" name="pro_datos_publicacion" />
                <input type="hidden" class="form-control" id="pro_otros_datos" name="pro_otros_datos" />
                
                <input type="hidden" class="form-control" id="pro_personas_atendidas" name="pro_personas_atendidas" />
            </form>

            <div class="modal-footer">
                <form action="./report.php" method="POST" id="GenerateReportFormGo">
                    <button type="button" class="btn btn-primary" style="float: left;" onclick="javascript: GenerateReport();" title="Generar un reporte completo del proyecto">Generar reporte</button>
                    <input type="hidden" id="GenerateReportArticleID" name="GenerateReportArticleID" />
                </form>
                
                <button type="button" class="btn btn-info" style="float: left;" onclick="javascript: ProjectResult();" title="Agregar resultados finales al proyecto">Agregar resultados</button>
                <?php
                    if (@$_SESSION['privilege'] == "Administrador"){
                        ?>
                            <button type="button" class="btn btn-danger" onclick="javascript: DelArtModal();" title="Eliminar el proyecto">Eliminar</button>
                        <?php
                    }
                ?>
                <button type="button" class="btn btn-info" onclick="javascript: UpdateListItemArt();" title="Actualizar información del proyecto">Actualizar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Opciones de la imagen seleccionada!. -->
<input type="hidden" class="SelectImgArticle" data-toggle="modal" data-target="#SelectImgArticle"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="SelectImgArticle" tabindex="1" role="dialog" aria-labelledby="MySelectImgArticle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MySelectImgArticle"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Vista previa</h3>
                            </div>
                            <div class="panel-body">
                                <img id="ImgArtBig" src="" />
                            </div>
                        </div>
                     </div>
                </div>
            </div>

            <form id="SendImgtoDeleteNow">
                <input type="hidden" id="newidimgdel" name="newidimgdel" />
                <input type="hidden" id="MynImgDel" name="MynImgDel" />
            </form>

            <div class="modal-footer">
                
                <?php
                    if ($_SERVER['PHP_SELF'] != "/project_vip/report.php"){
                        ?>
                            <button type="button" class="btn btn-danger" onclick="javascript: DelArtModalImage();">Eliminar</button>
                        <?php
                    }
                ?>

                 <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Artículo actualizado con éxito!. -->
<input type="hidden" class="InfoArtUpdateYes" data-toggle="modal" data-target="#InfoArtUpdateYes"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="InfoArtUpdateYes" tabindex="1" role="dialog" aria-labelledby="MyInfoArtUpdateYes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyInfoArtUpdateYes">Actualización del proyecto</h4>
            </div>
            <div class="modal-body">
                <h4>El proyecto fue actualizado con éxito</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="javascript: window.location.href='./projects';" data-dismiss="modal">¡OK!...</button>
            </div>
        </div>
    </div>
</div>


<!-- ¿Está seguro que desea eliminar el elemento? -->
<input type="hidden" class="DelArtModal" data-toggle="modal" data-target="#DelArtModal"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="DelArtModal" tabindex="1" role="dialog" aria-labelledby="MyDelArtModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyDelArtModal">Eliminar proyecto</h4>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea eliminar el Proyecto?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="javascript: DelArtNow();">Sí</button>
            </div>
        </div>
    </div>
</div>

<!-- ¿Está seguro que desea eliminar la imagen seleccionada? -->
<input type="hidden" class="DelArtModalImage" data-toggle="modal" data-target="#DelArtModalImage"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="DelArtModalImage" tabindex="1" role="dialog" aria-labelledby="MyDelArtModalImage" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyDelArtModalImage">Eliminar imagen seleccionada</h4>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea eliminar la imagen seleccionada?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default exit_default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="javascript: DelImgArtNow();">Sí</button>
            </div>
        </div>
    </div>
</div>


<!-- ¿Cambiar correo electrónico? -->
<input type="hidden" class="ChgEmail" data-toggle="modal" data-target="#ChgEmail"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ChgEmail" tabindex="1" role="dialog" aria-labelledby="MyChgEmail" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyChgEmail"><i class="fa fa-pencil"></i> Modificar E-mail</h4>
            </div>
            <div class="modal-body">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-xs-6">
                            <span class="panel-icon">
                                 <i class="fa fa-pencil"></i>
                            </span>
                            <span class="panel-title">Correo electrónico actual.</span>
                            
                            <h5 id="h5_email" style="margin-left: 50px; background-color: #F0F0F0; padding: 10px; border-radius: 12px; width: -moz-max-content;">
                                 <!-- <span class="icon fa fa-user"></span> -->
                                 <i class="fa fa-envelope" aria-hidden="true"></i>
                                <?php
                                    echo $CN->getUserEmail(@$_SESSION['usr']);
                                ?>
                            </h5>
                        </div>

                        <div class="col-xs-6">
                            <?php
                               if (is_array($QImg)){
                                    foreach ($QImg as $value) {
                                        ?>
                                            <div style="background: url('private/desktop0/<?php echo $value['folder'].$value['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                            </div>
                                        <?php
                                    }
                                } else if (is_bool($QImg)) {
                                    ?>
                                        <div style="background: url('<?php echo "../".$src_img_ext['folder'].$src_img_ext['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                        
                    </div>
                </div>

                <form id="ChgEAdressFrom">
                    <input type="text" class="form-control" id="new_email_address" name="new_email_address" placeholder="* Escriba la nueva dirección de correo electrónico" />
                </form>
            </div>
            <div class="modal-footer">
                <?php
                    if (@$_SESSION['privilege'] == "Administrador"){
                        ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;" onclick="javascript: CreateUserNow();">Crear usuario</button>
                        <?php
                    }
                ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: ApplyChgEmail();">Aplicar</button>
            </div>
        </div>
    </div>
</div>

<!-- ¿Cambiar nombre de usuario? -->
<input type="hidden" class="ChgUserPerfil" data-toggle="modal" data-target="#ChgUserPerfil"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ChgUserPerfil" tabindex="1" role="dialog" aria-labelledby="MyChgUserPerfil" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyChgUserPerfil"><i class="fa fa-pencil"></i> Modificar nombre de usuario</h4>
            </div>
            <div class="modal-body">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-xs-8">
                            <span class="panel-icon">
                                 <i class="fa fa-pencil"></i>
                            </span>
                            <span class="panel-title">El nombre de usuario tiene que ser único.</span>
                            
                            <h5 id="h5_username" style="margin-left: 50px; background-color: #F0F0F0; padding: 10px; border-radius: 12px; width: -moz-max-content;">
                                <span class="icon fa fa-user"></span>
                                <?php
                                    echo @$_SESSION['usr'];
                                ?>
                            </h5>
                        </div>

                        <div class="col-xs-4">
                            <?php
                               if (is_array($QImg)){
                                    foreach ($QImg as $value) {
                                        ?>
                                            <div style="background: url('private/desktop0/<?php echo $value['folder'].$value['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                            </div>
                                        <?php
                                    }
                                } else if (is_bool($QImg)) {
                                    ?>
                                        <div style="background: url('<?php echo "../".$src_img_ext['folder'].$src_img_ext['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>

                        
                    </div>
                </div>

                <form id="ChgUserPerfilForm">
                    <input type="text" class="form-control" id="new_user_perfil" name="new_user_perfil" placeholder="* Escriba el nuevo nombre de usuario" />
                </form>
                <div class="Incrustar">
                    
                </div>
            </div>
            <div class="modal-footer">
                
                <?php
                    if (@$_SESSION['privilege'] == "Administrador"){
                        ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;" onclick="javascript: CreateUserNow();">Crear usuario</button>
                        <?php
                    }
                ?>
            
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: ApplyChgUserName();">Aplicar</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" class="ChgPersonalForm" data-toggle="modal" data-target="#ChgPersonalForm"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ChgPersonalForm" tabindex="1" role="dialog" aria-labelledby="MyChgPersonalForm" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyChgPersonalForm"><i class="fa fa-pencil"></i> Modificar identificación personal</h4>
            </div>
            <div class="modal-body">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-xs-8">
                            <span class="panel-icon">
                                 <i class="fa fa-pencil"></i>
                            </span>
                            <span class="panel-title">Escriba nombres y apellidos.</span>
                            
                            <h5 id="h5_usernameFirstname_Lastname" style="margin-left: 50px; background-color: #F0F0F0; padding: 10px; border-radius: 12px; width: -moz-max-content;">
                                <span class="icon fa fa-user"></span>
                                <?php
                                    $Firstname_Lastname = $CNEx->getUserFirstname_Lastname($_SESSION['usr']);
                                    if (is_bool($Firstname_Lastname) || $Firstname_Lastname == ""){
                                        echo @$_SESSION['usr'];
                                    } else {
                                        echo $Firstname_Lastname;
                                    }

                                ?>
                            </h5>
                        </div>

                        <div class="col-xs-4">
                            <?php
                               if (is_array($QImg)){
                                    foreach ($QImg as $value) {
                                        ?>
                                            <div style="background: url('private/desktop0/<?php echo $value['folder'].$value['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                            </div>
                                        <?php
                                    }
                                } else if (is_bool($QImg)) {
                                    ?>
                                        <div style="background: url('<?php echo "../".$src_img_ext['folder'].$src_img_ext['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>

                        
                    </div>
                </div>

                <form id="ChgUserFirstname_Lastname">
                    <input type="text" class="form-control" id="new_user_firstname_lastname" name="new_user_firstname_lastname" placeholder="* Escriba los nombres y apellidos del usuario" />
                </form>
                <div class="Incrustar">
                    
                </div>
            </div>
            <div class="modal-footer">
                
                <?php
                    if (@$_SESSION['privilege'] == "Administrador"){
                        ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;" onclick="javascript: CreateUserNow();">Crear usuario</button>
                        <?php
                    }
                ?>
            
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: ApplyChgFirstname_Lastname();">Aplicar</button>
            </div>
        </div>
    </div>
</div>

<!-- Menu de configuración -->
<input type="hidden" class="MenuConfig" data-toggle="modal" data-target="#MenuConfig"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="MenuConfig" tabindex="1" role="dialog" aria-labelledby="MyMenuConfig" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyMenuConfig"><span class="icon fa fa-user"></span> Configuración de usuario</h4>
            </div>
            <div class="modal-body">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <a href="#" onclick="javascript: ChgUserPerfil('close');">
                                <div class="card blue summary-inline">
                                    <div class="card-body">
                                        <i class="icon fa fa-user fa-4x"></i>
                                        <div class="content">
                                            <div class="title">UN</div>
                                            <div class="sub-title">Modificar nombre de usuario</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <a href="#" onclick="javascript: ChgEmailModal('close');">
                                <div class="card yellow summary-inline">
                                    <div class="card-body">
                                        <i class="icon fa fa-envelope fa-4x"></i>
                                        <div class="content">
                                            <div class="title">E-M</div>
                                            <div class="sub-title">Modificar correo electrónico</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <a href="#" onclick="javascript: ChgPasswordModal('close');">
                                <div class="card green summary-inline">
                                    <div class="card-body">
                                        <i class="icon fa fa-key fa-4x"></i>
                                        <div class="content">
                                            <div class="title">PW</div>
                                            <div class="sub-title">Modificar contraseña</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- ¿Cambiar contraseña? -->
<input type="hidden" class="ChgPasswordModal" data-toggle="modal" data-target="#ChgPasswordModal"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ChgPasswordModal" tabindex="1" role="dialog" aria-labelledby="MyChgPasswordModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyChgPasswordModal"><i class="fa fa-pencil"></i> Modificar contraseña</h4>
            </div>
            <div class="modal-body">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-xs-8">
                            <span class="panel-icon">
                                 <i class="fa fa-pencil"></i>
                            </span>
                            <span class="panel-title">Escriba la nueva contraseña para el usuario: </span>
                            
                            <h5 id="h5_username" style="margin-left: 50px; background-color: #F0F0F0; padding: 10px; border-radius: 12px; width: -moz-max-content;">
                                <i class="fa fa-key"></i>
                                <?php echo @$_SESSION['usr']; ?>
                            </h5>
                        </div>

                        <div class="col-xs-4">
                            <?php
                               if (is_array($QImg)){
                                    foreach ($QImg as $value) {
                                        ?>
                                            <div style="background: url('private/desktop0/<?php echo $value['folder'].$value['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                            </div>
                                        <?php
                                    }
                                } else if (is_bool($QImg)) {
                                    ?>
                                        <div style="background: url('<?php echo "../".$src_img_ext['folder'].$src_img_ext['src']; ?>'); width: 80px; height:80px; border-radius: 50% 50%; background-size: 100% 100%; border: 3px solid lightgrey; float: right;">
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <form id="ChgPassPerfilForm">
                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="* Escriba la contraseña actual" /><br/>
                    <input type="password" class="form-control" id="new_passwordUser" name="new_passwordUser" placeholder="* Nueva contraseña" /><br/>
                    <input type="password" class="form-control" id="repeat_new_passwordUser" name="repeat_new_passwordUser" placeholder="* Repita la contraseña" />
                </form>
                <div class="Incrustar_password">
                    
                </div>
            </div>
            <div class="modal-footer">
                <?php
                    if (@$_SESSION['privilege'] == "Administrador"){
                        ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;" onclick="javascript: CreateUserNow();">Crear usuario</button>
                        <?php
                    }
                ?>

                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: ApplyChgPW();">Aplicar</button>
            </div>
        </div>
    </div>
</div>


<!-- Crear un nuevo usuario -->

<?php
    if (@$_SESSION['privilege'] == "Administrador"){
        ?>
            <input type="hidden" class="CreateUserNow" data-toggle="modal" data-target="#CreateUserNow"  />

            <div class="modal fade modal-primary" id="CreateUserNow" tabindex="1" role="dialog" aria-labelledby="MyCreateUserNow" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="MyCreateUserNow"><span class="icon fa fa-user"></span> Crear usuario</h4>
                            <ul class="nav nav-pills mb20" style="position: absolute; right: 66px; top: 8px;">
                                <li class="active" onclick="javascript: AssignPrivilege('Limitado');" >
                                    <a href="#tab18_1" data-toggle="tab" aria-expanded="true" style="color:#fff;">
                                        <span class="icon fa fa-user"></span> Limitado
                                    </a>
                                </li>
                              
                                <li class="" onclick="javascript: AssignPrivilege('Administrador');">
                                    <a href="#tab18_2" data-toggle="tab" aria-expanded="false" style="color:#fff;">
                                        <span class="icon fa fa-user"></span> Administrador
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-body">
                            
                            <form id="SendEnterNewUser">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-tag" aria-hidden="true"></i> Nombre de usuario, E-mail</h3>
                                            </div>
                                            <div class="panel-body">
                                                <input type="text" class="form-control" name="Enter_UserName" id="Enter_UserName" placeholder="* Nombre de usuario" /><br/>
                                                <input type="text" class="form-control" name="Enter_Email" id="Enter_Email" placeholder="* Correo electrónico" />
                                                
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-xs-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-key" aria-hidden="true"></i> Escriba la clave</h3>
                                            </div>
                                            <div class="panel-body">
                                                <input type="password" class="form-control" name="Enter_PassWord" id="Enter_PassWord" placeholder="* Contraseña" /><br/>
                                                <input type="password" class="form-control" name="Enter_RepeatPassWord" id="Enter_RepeatPassWord" placeholder="* Repita la contraseña" />
                                            </div>
                                        </div>
                                     </div>

                                     <input type="hidden" id="ValuePrivilege" name="ValuePrivilege" value="Limitado" />

                                      <div class="panel-body">
                                        <div class="tab-content br-n pn">
                                          <div id="tab18_1" class="tab-pane active">
                                            <div class="row">
                                              <div class="col-md-12">
                                               
                                                <div class="alert alert-micro alert-border-left alert-primary alert-dismissable">
                                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                  <i class="fa fa-trophy pr10"></i>
                                                  <strong>!Bien hecho!</strong> Ha seleccionado el privilegio Limitado para este usuario.
                                                  <a href="#" class="alert-link">Échale un vistazo a sus derechos</a>.
                                                </div>

                                              </div>
                                            </div>
                                          </div>

                                          <div id="tab18_2" class="tab-pane">
                                            <div class="row">
                                              <div class="col-md-12">
                                                 <div class="alert alert-micro alert-border-left alert-primary alert-dismissable">
                                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                  <i class="fa fa-trophy pr10"></i>
                                                  <strong>!Bien hecho!</strong> Ha seleccionado el privilegio Administrador para este usuario.
                                                  <a href="#" class="alert-link">Échale un vistazo a sus derechos</a>.
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="javascript: CreateTheUser();">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>



<!-- Detalles del usuario -->
<input type="hidden" class="Details_username" data-toggle="modal" data-target="#Details_username"  />

<div class="modal fade modal-primary" id="Details_username" tabindex="1" role="dialog" aria-labelledby="MyDetails_username" aria-hidden="true">
    <ul class="nav nav-pills mb20" style="max-width: 130px;margin: 10px auto;">
        <li class="active">
            <a href="#" data-toggle="tab" class="aHTMLAddPrivilege" aria-expanded="true" style="color:#fff;">
                <span class="icon fa fa-user"></span> ...
            </a>
        </li>
    </ul>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyDetails_username"></h4>
            </div>
            <div class="modal-body">

                <div class="panel">
                  <div class="panel-heading panel-visible">
                    <div class="widget-menu pull-right mr10" style="position: absolute;right: 70px;top: -45px;">
                      
                      
                      <div class="btn-group">
                        <button type="button" style="padding: 5px;" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-globe"></span> Estado de la cuenta</button>
                      
                        <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                          <li onclick="javascript: ChangePrivilegeState('Administrador');">
                            <a style="cursor: pointer;"><span class="fa fa-user-md"></span> Administrador </a>
                          </li>
                          <li onclick="javascript: ChangePrivilegeState('Limitado');">
                            <a style="cursor: pointer;"><span class="fa fa-tachometer"></span> Limitado </a>
                          </li>
                          <li onclick="javascript: ChangePrivilegeState('Suspendido');">
                            <a style="cursor: pointer;"><span class="fa fa-exclamation-triangle"></span> Suspendido </a>
                          </li>
                        </ul>
                      
                        <form id="ChangePrivilegeForm">
                            <input type="hidden" id="InputUsrPrivilege" name="InputUsrPrivilege" />
                            <input type="hidden" id="InputPrivilege" name="InputPrivilege" />
                        </form>

                      </div>
                    </div>
                  </div>
                </div>

                <form id="DataEnterDelUser">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Usuario, E-mail, Fecha</h3>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="DataDel_UserName" id="DataDel_UserName" placeholder="* Nombre de usuario" /><br/>
                                    <input type="text" class="form-control" name="DataDel_Email" id="DataDel_Email" placeholder="* Correo electrónico" /><br/>
                                    <input type="text" class="form-control" name="DataDel_Publish" id="DataDel_Publish" placeholder="Fecha de publicación" /><br/>
                                </div>
                            </div>
                         </div>
                         <div class="col-xs-6">
                            <div class="insert_img_user">
                            </div>
                         </div>
                    </div>
                </form>

               <input type="hidden" id="objt_username" value="<?php echo @$_SESSION['usr']; ?>" />

            </div>
            <div class="modal-footer modal_footer_ya">
                
            </div>
        </div>
    </div>
</div>


<!-- ¿Está seguro que desea eliminar el usuario? -->
<input type="hidden" class="OpenModalDeleteLie" data-toggle="modal" data-target="#OpenModalDeleteLie"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenModalDeleteLie" tabindex="1" role="dialog" aria-labelledby="MyOpenModalDeleteLie" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyOpenModalDeleteLie"><span class="icon fa fa-trash"></span> Eliminar usuario</h4>
            </div>
            <div class="modal-body">
                <p><b>¿Seguro que desea eliminar el usuario?</b></p>
                <p>Si elimina el usuario, la actividad que este haya creado, se eliminará, ya que se encontrará sin propietario.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="javascript: DelUserShure();">Sí</button>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal que sirve para agregar un autor al reporte-->
<input type="hidden" class="OpenModalAutorReporte" data-toggle="modal" data-target="#OpenModalAutorReporte"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenModalAutorReporte" tabindex="1" role="dialog" aria-labAutorReporte" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyOpenModalAutorReporte"><span class="icon fa fa-info"></span> Generación de reporte</h4>
            </div>
            <div class="modal-body">
                <p><b>Firma del reporte</b></p>
                <p>Por favor, agregue el nombre y título del autor, del personaje que firmará este reporte.</p>
                <input type="text" id="AutorReporte" style="width: 100%; padding: 10px;" placeholder="Agregar nombre del autor a firmar" name="AutorReporte" value="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="javascript: GenerateReportPDF();">Continuar</button>
            </div>
        </div>
    </div>
</div


<!-- Mostra la lista de suscripciones -->
<input type="hidden" class="OpenListSuscriptions" data-toggle="modal" data-target="#OpenListSuscriptions"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenListSuscriptions" tabindex="1" role="dialog" aria-labelledby="MyOpenListSuscriptions" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyOpenListSuscriptions">Suscriptores</h4>
            </div>
            <div class="modal-body modal_suscriptions_char">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Se muestra la confirmación del acerca de nosotros. -->
<input type="hidden" class="OpenModalAboutUs" data-toggle="modal" data-target="#OpenModalAboutUs"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenModalAboutUs" tabindex="1" role="dialog" aria-labelledby="MyOpenModalAboutUs" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MyOpenModalAboutUs">Acerca de nosotros</h4>
            </div>
            <div class="modal-body modal_suscriptions_char">
                <p>El texto fue agregado con éxito.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Se muestra esta modal si ha ocurrido un error al cargar los datos en la DB. -->
<input type="hidden" class="OMAboutUsError" data-toggle="modal" data-target="#OMAboutUsError"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OMAboutUsError" tabindex="1" role="dialog" aria-labelledby="MOMAboutUsError" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MOMAboutUsError">Acerca de nosotros</h4>
            </div>
            <div class="modal-body modal_suscriptions_char">
                <p>Ha ocurrido un problema inesperado, por favor, vuelva a intentarlo!.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Se muestra la modal que afirma que los datos se han agregado con éxito. -->
<input type="hidden" class="OpenModalContactUs" data-toggle="modal" data-target="#OpenModalContactUs"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenModalContactUs" tabindex="1" role="dialog" aria-labelledby="OMContactUs" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="OMContactUs">Contáctanos</h4>
            </div>
            <div class="modal-body modal_suscriptions_char">
                <p>Los datos se han agregdado con éxito.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Ha ocurrido un error al intentar agregar los datos. -->
<input type="hidden" class="OpenModalContactUsError" data-toggle="modal" data-target="#OpenModalContactUsError"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenModalContactUsError" tabindex="1" role="dialog" aria-labelledby="OMContactUsError" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="OMContactUsError">Contáctanos</h4>
            </div>
            <div class="modal-body modal_suscriptions_char">
                <p>Up's. Ha ocurrido un problema al intentar agregar los datos, por favor, vuelva a intentarlo.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar más información sobre el mensaje recibido -->
<input type="hidden" class="OpenMessage" data-toggle="modal" data-target="#OpenMessage"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenMessage" tabindex="1" role="dialog" aria-labelledby="OpenedMessage" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ShowMessageBox">
            <!-- Here the code PHP with the information of the message -->
        </div>
    </div>
</div>

<!-- Problemas al extraer los datos de la DB / sus_message -->
<input type="hidden" class="OpenModalMessageError" data-toggle="modal" data-target="#OpenModalMessageError"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="OpenModalMessageError" tabindex="1" role="dialog" aria-labelledby="PMErrorMessage" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="PMErrorMessage">Up's, problemas.</h4>
            </div>
            <div class="modal-body">
                <p>Up's. Ha ocurrido un problema al intentar extraer detalles del mensaje, por favor, recargue la página e intentelo nuevamente. ¡Gracias!.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Por favor, rellenar el campo de mensaje / sus_message -->
<input type="hidden" class="HeyHopeOneMoment" data-toggle="modal" data-target="#HeyHopeOneMoment"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="HeyHopeOneMoment" tabindex="1" role="dialog" aria-labelledby="HeyhopeMoment" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="HeyhopeMoment">Advertencia</h4>
            </div>
            <div class="modal-body">
                <p>No ha rellenado el campo de mensaje, hasta que lo haga, el mensaje será enviado, por favor, escriba su mensaje. ¡Gracias!.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Muestra todos los mensajes que han sido enviados. -->
<input type="hidden" class="ShowMSGSended" data-toggle="modal" data-target="#ShowMSGSended"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ShowMSGSended" tabindex="1" role="dialog" aria-labelledby="ShowMSGSendedItem" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="card-body no-padding">
                <ul class="message-list view_all_messages">
                    <!-- Here code sus_messages -->
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary close_modal_now" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Muestra todos los mensajes que han sido enviados y que son favoritos. -->
<input type="hidden" class="ShowMSGSendedFav" data-toggle="modal" data-target="#ShowMSGSendedFav"  />

<!-- Modal -->
<div class="modal fade modal-primary" id="ShowMSGSendedFav" tabindex="1" role="dialog" aria-labelledby="ShowMSGSendedItem" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="card-body no-padding">
                <ul class="message-list view_all_messages_favorite">
                    <!-- Here code sus_message_favorite -->
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary close_modal_now" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
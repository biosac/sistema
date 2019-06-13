<template>
    <section class='content'>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Categorías</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <button type="button" @click="abrirModal('categoria','registrar','')" class="btn btn-secondary">
                        <span class="glyphicon glyphicon-copy"></span>&nbsp;Nuevo
                    </button>
                    <button type="button" @click="abrirModal('categoria','registrar','')" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                        <span class="glyphicon glyphicon-copy"></span>&nbsp;Nuevo
                    </button>
                </div>
                <div class="form-group">
                    <table class="table table-bordered table-striped" id="example2">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                                <td style="text-align:center;width:120px;">
                                    <button type="button" @click="abrirModal('categoria','actualizar',categoria)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </td>
                                <td v-text="categoria.nombre"></td>
                                <td v-text="categoria.descripcion"></td>
                                <td>
                                    <div v-if="categoria.condicion"><span class="label label-success">Activo</span></div>
                                    <div v-else><span class="label label-danger">Inactivo</span></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" @click="cerrarModal()" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-6">
                                    <input type="text" v-model="nombre" placeholder="Ingrese nombre" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Descripción</label>
                                <div class="col-sm-6">
                                    <input type="text" v-model="descripcion" placeholder="Ingrese descripción" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button tyle="button" @click="registrarCategoria()" v-if="tipoAccion==1" class="btn btn-primary">Guardar</button>
                        <button tyle="button" v-else class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog modal-lg" style="width:50%;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-6">
                                    <input type="text" v-model="nombre" placeholder="Ingrese nombre" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Descripción</label>
                                <div class="col-sm-6">
                                    <input type="text" v-model="descripcion" placeholder="Ingrese descripción" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button tyle="button" v-if="tipoAccion==1" class="btn btn-primary" data-dismiss="modal" @click="registrarCategoria()">Guardar</button>
                        <button tyle="button" v-else class="btn btn-primary" data-dismiss="modal">Actualizar</button>
                        <button type="button" @click="cerrarModal()" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data(){
            return {
                nombre: '',
                descripcion: '',
                arrayCategoria: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorCategoria: 0,
                errorMostrarMsjCategoria: [],
            }
        },
        methods: {
            listarCategoria(){
                let me = this;
                axios.get('/categoria')
                .then(function (response) {
                    me.arrayCategoria = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                });
            },
            registrarCategoria(){
                let me=this;
                axios.post('/categoria/registrar',{
                    'nombre':this.nombre,
                    'descripcion':this.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarCategoria();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "categoria":{
                        switch(accion){
                            case "registrar": {
                                //this.modal=1;
                                this.nombre="";
                                this.descripcion="";
                                this.tituloModal="Registrar Categoría";
                                this.tipoAccion=1;
                                break;
                            }
                            case "actualizar": {
                                //this.modal=1;
                                this.tituloModal="Actualizar Categoría";
                                this.nombre=data.nombre;
                                this.descripcion=data.descripcion;
                                this.tipoAccion=2;
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                //this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.tipoAccion=0;
            }
        },
        mounted() {
            this.listarCategoria();
        }
    }
</script>
<style>
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        /*background-color: #3c29297a !important;*/
    }
    .modal-dialog {
        padding-top: 80px !important;
    }
    .modal-header {
        background-color: #3c8dbc !important;
        color: white !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>

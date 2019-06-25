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
                    <div style="padding-bottom:10px;">
                        <div class="form-inline">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                <option value="descripcion">Descripción</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarCategoria(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarCategoria(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm" id="example2">
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
                                    <button type="button" @click="abrirModal('categoria','actualizar',categoria)" class="btn btn-warning btn-sm">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </button>
                                    <template v-if="categoria.condicion">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(categoria.id)">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarCategoria(categoria.id)">
                                            <i class="glyphicon glyphicon-ok"></i>
                                        </button>
                                    </template>
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
                    <nav style="float:right;">
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-else>
                                <a class="page-link" style="disabled">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                            <li class="page-item" v-else>
                                <a class="page-link" style="disabled">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>

        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="cerrarModal()">&times;</button>
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                </div>
                            </div>
                            <div v-show="errorCategoria" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCategoria()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCategoria()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </section>
</template>
<script>
    export default {
        data(){
            return {
                nombre: '',
                descripcion: '',
                categoria_id: 0,
                arrayCategoria: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorCategoria: 0,
                errorMostrarMsjCategoria: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                offset: 3,
                criterio: 'nombre',
                buscar: ''
            }
        },
        computed: {
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            listarCategoria(page,buscar,criterio){
                let me = this;
                var url = '/categoria?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                me.listarCategoria(page,buscar,criterio);
            },
            registrarCategoria(){
                if (this.validarCategoria()){
                    return;
                }
                let me=this;
                axios.post('/categoria/registrar',{
                    'nombre':this.nombre,
                    'descripcion':this.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');
                    this.errorCategoria=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCategoria(){
                if(this.validarCategoria()){
                    return;
                }
                let me = this;
                axios.put('/categoria/actualizar',{
                    'nombre':this.nombre,
                    'descripcion':this.descripcion,
                    'id':this.categoria_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            desactivarCategoria(id){
                swal({
                title: "¿Confirma la desactivación del elemento?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: {
                    cancel: "Cancelar",
                    catch: {
                        text: "Aceptar",
                        value: "aceptar",
                    },
                }
                })
                .then((value) => {
                    if (value=="aceptar") {
                        let me = this;
                        axios.put('/categoria/desactivar',{
                            'id':id
                        }).then(function(response){
                            me.listarCategoria(1,'','nombre');
                            swal("¡Operación exitosa! Se ha desactivado el registro...", {icon: "success",});
                        }).catch(function(error){
                            console.log(error);
                        });
                    } 
                });
            },
            activarCategoria(id){
                swal({
                title: "¿Confirma la activación del elemento?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: {
                    cancel: "Cancelar",
                    catch: {
                        text: "Aceptar",
                        value: "aceptar",
                    },
                }
                })
                .then((value) => {
                    if (value=="aceptar") {
                        let me = this;
                        axios.put('/categoria/activar',{
                            'id':id
                        }).then(function(response){
                            me.listarCategoria(1,'','nombre');
                            swal("¡Operación exitosa! Se ha activado el registro...", {icon: "success",});
                        }).catch(function(error){
                            console.log(error);
                        });
                    } 
                });
            },
            validarCategoria(){
                this.errorCategoria=0;
                this.errorMostrarMsjCategoria =[];
                if (!this.nombre) this.errorMostrarMsjCategoria.push("El nombre de la categoría no puede estar vacío.");
                if (this.errorMostrarMsjCategoria.length) this.errorCategoria = 1;
                return this.errorCategoria;
            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "categoria":{
                        switch(accion){
                            case "registrar": {
                                this.modal=1;
                                this.nombre="";
                                this.descripcion="";
                                this.tituloModal="Registrar Categoría";
                                this.tipoAccion=1;
                                break;
                            }
                            case "actualizar": {
                                this.modal=1;
                                this.tituloModal="Actualizar Categoría";
                                this.nombre=data['nombre'];
                                this.descripcion=data['descripcion'];
                                this.categoria_id=data['id'];
                                this.tipoAccion=2;
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.errorCategoria=0;
            }
        },
        mounted() {
            this.listarCategoria(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    .modal-header{
        background-color: #367fa9 !important;
        color: white !important;
    }
    .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th{
        background-color: #4c88bb  !important;
        color: white;
    }
</style>

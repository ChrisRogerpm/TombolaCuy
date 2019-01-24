@extends('Shared.layout')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                                <div class="block-content-outer">
                                    <div class="block-content-inner">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <h6>
                                                    <i class="glyphicon glyphicon-th mr-2"></i>
                                                    Reporte de Historial de Ganadores Por Tienda.
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <a href="#"
                                       class="btn btn-primary btn-sm col-md-12 col-xs-12"><span
                                                class="glyphicon glyphicon-search"></span> Buscar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <form id="frmNuevo" autocomplete="off">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Fecha Inicio</label>
                                    <div class="prepend-icon">
                                        <input type="text" name="datepicker" class="date-picker form-control hasDatepicker" placeholder="Fecha Inicio"  id="fechaInicio">
                                        <i class="icon-calendar"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label class="form-label">Fecha Fin</label>
                                <div class="prepend-icon">
                                    <input type="text" name="datepicker" class="date-picker form-control hasDatepicker" placeholder="Fecha Fin" id="fechaFin">
                                    
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tiendas</label>
                                    <select class="form-control input-sm select2" style="width: 100%;">
                                        <option value="0">--Seleccione--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <table id="table" class="table table-bordered table-striped dataTable no-footer" style="width:100%" role="grid" aria-describedby="table_info">
   <thead>
      <tr role="row">
                         

         <th class="sorting_asc" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Id: activate to sort column descending">tienda</th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column ascending">evento</th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Multiplicador Defecto: activate to sort column ascending">fecha</th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Estado: activate to sort column ascending">total jugadores</th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Pleno Minimo: activate to sort column ascending">total ganadores</th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Pleno Maximo: activate to sort column ascending">monto total apostado</th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Intercalado: activate to sort column ascending">monto total pagado  </th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Intercalado: activate to sort column ascending">NR ticket ganador  </th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Intercalado: activate to sort column ascending">tipo de apuesta  </th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Intercalado: activate to sort column ascending">valor de apuesta </th>
         <th class="sorting" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label=": activate to sort column ascending"></th>
      </tr>
   </thead>
   <tbody>
      <tr role="row" class="odd">
         <td class="sorting_1">1</td>
         <td>Pleno</td>
         <td>1.10</td>
         <td>Activo</td>
         <td>1</td>
         <td>3</td>
         <td>1</td>
         <td>dato</td>
         <td>dato2</td>
         <td>dato3</td>
         <td><button type="button" class="btn btn-success btn-sm btnEditar" data-id="1" data-original-title="" title=""><i class="fa fa-edit"></i></button></td>
      </tr>
      <tr role="row" class="even">
         <td class="sorting_1">2</td>
         <td>Color</td>
         <td>1.40</td>
         <td>Activo</td>
         <td>1</td>
         <td>3</td>
         <td>1</td>
         <td>dato</td>
         <td>dato2</td>
         <td>dato3</td>
         <td><button type="button" class="btn btn-success btn-sm btnEditar" data-id="2" data-original-title="" title=""><i class="fa fa-edit"></i></button></td>
      </tr>
      <tr role="row" class="odd">
         <td class="sorting_1">3</td>
         <td>Par e Impar</td>
         <td>1.50</td>
         <td>Activo</td>
         <td>1</td>
         <td>3</td>
         <td>1</td>
         <td>dato</td>
         <td>dato2</td>
         <td>dato3</td>
         <td><button type="button" class="btn btn-success btn-sm btnEditar" data-id="3" data-original-title="" title=""><i class="fa fa-edit"></i></button></td>
      </tr>
      <tr role="row" class="even">
         <td class="sorting_1">4</td>
         <td>1era, 2da, 3ra ½ docena</td>
         <td>1.10</td>
         <td>Activo</td>
         <td>1</td>
         <td>3</td>
         <td>1</td>
         <td>dato</td>
         <td>dato2</td>
         <td>dato3</td>
         <td><button type="button" class="btn btn-success btn-sm btnEditar" data-id="4" data-original-title="" title=""><i class="fa fa-edit"></i></button></td>
      </tr>
      <tr role="row" class="odd">
         <td class="sorting_1">5</td>
         <td>Del 1 al 12, 13 al 24</td>
         <td>1.20</td>
         <td>Activo</td>
         <td>1</td>
         <td>3</td>
         <td>1</td>
         <td>dato</td>
         <td>dato2</td>
         <td>dato3</td>
         <td><button type="button" class="btn btn-success btn-sm btnEditar" data-id="5" data-original-title="" title=""><i class="fa fa-edit"></i></button></td>
      </tr>
      <tr role="row" class="even">
         <td class="sorting_1">6</td>
         <td>CajaBoqueda</td>
         <td>1.60</td>
         <td>Activo</td>
         <td>1</td>
         <td>3</td>
         <td>1</td>
         <td>dato</td>
         <td>dato2</td>
         <td>dato3</td>
         <td><button type="button" class="btn btn-success btn-sm btnEditar" data-id="6" data-original-title="" title=""><i class="fa fa-edit"></i></button></td>
      </tr>
      <tr role="row" class="odd">
         <td class="sorting_1">7</td>
         <td>registro pago</td>
         <td>4.00</td>
         <td>Activo</td>
         <td>6</td>
         <td>22</td>
         <td>5</td>
         <td><button type="button" class="btn btn-success btn-sm btnEditar" data-id="7" data-original-title="" title=""><i class="fa fa-edit"></i></button></td>
      </tr>
   </tbody>
</table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('../assets/Reporte/ReporteHistorialGanadores.js')}}"></script>
@endpush
@extends('base.administrativo.blank')

@section('titulo')
    Reportes Académicos
@endsection

@section('contenido')
<div>
    <div class="flex text-xl items-center mb-4 gap-2">
        <span class="hidden md:inline dark:text-white">Reportes Académicos</span>
        <span class="hidden md:inline dark:text-white">/</span>
        <select name="tipo-reporte" class="w-full md:w-auto" id="selector-reporte">
            <option value="alumnosMatriculados">Alumnos Matriculados</option>
            <option value="alumnosNuevosVsAntiguos">Alumnos nuevos vs antiguos</option>
            <option value="alumnosPorGenero">Alumnos por género</option>
            <option value="alumnosRetirados">Alumnos retirados</option>
            <option value="alumnosPorGradoDeEdad">Alumnos por grado de edad</option>
        </select>
    </div>
</div>

<div class="mb-4 flex items-center gap-6">
    <div id="año-evaluado-filter">
        <span>Año evaluado</span>
        <select name="añoEvaluado" id="año-evaluado">
        </select>
    </div>

    <div id="nivel-educativo-evaluado-filter">
        <span>Nivel Educativo</span>
        <select name="nivelEducativo" id="nivel-educativo-evaluado">
        </select>
    </div>

    <!-- Falta implementar control de grados según nivel educativo -->
    <div id="grado-evaluado-filter" hidden>
        <span>Grado</span>
        <select name="gradoEvaluado" id="grado-evaluado">
        </select>
    </div>
</div>

<div class="grid grid-cols-2 grid-rows-3 gap-4 max-h-200 sm:max-h-150 lg:max-h-screen">
    <div class="flex relative row-start-1 row-end-3 col-start-1 col-end-3 justify-center">
        <canvas class="text-white" id="myChart"></canvas>
    </div>
</div>

@endsection

@section('custom-js')

<script src={{ asset('js/graphjs-api.js') }}></script>

<script>
    async function requestGraphJS(endpoint, params = {}){
        window.chartCfg = await GraphJSApi.get(endpoint, params)
            .then(response => response)
            .catch(error => {
                console.error("Error al obtener los datos: ", error);
            });

        return chartCfg;
    }

    function loadChart(config) {
        const ctx = document.getElementById('myChart');
        if (window.grafico0) grafico0.destroy();
        if (config.options.length == 0) config.options = {}

        window.grafico0 = new Chart(ctx, config);
    }

    function loadFilters(config) {
        for (var idSelector in selectores.filtros) {
            selectores.filtros[idSelector].clearOptions();
            selectores.filtros[idSelector].addOption({value: '', text: 'Todos'});
            selectores.filtros[idSelector].setValue('', true);
        }

        if (config.extra.añosEscolares)
            selectores.filtros.añoEvaluado.addOption(config.extra.añosEscolares.map(año => ({value: año, text: año})));

        if (config.extra.nivelesEducativos)
            selectores.filtros.nivelEducativo.addOption(config.extra.nivelesEducativos.map(nivel => ({value: nivel, text: nivel})));

        if (config.extra.grados)
            selectores.filtros.gradoEvaluado.addOption(config.extra.grados.map(grado => ({value: grado, text: grado})));

        selectores.filtros.añoEvaluado.refreshOptions();
        selectores.filtros.nivelEducativo.refreshOptions();
        selectores.filtros.gradoEvaluado.refreshOptions();
    }

    function loadGrados(config){
        selectores.filtros.gradoEvaluado.clearOptions();
        selectores.filtros.gradoEvaluado.addOption({value: '', text: 'Todos'});
        selectores.filtros.gradoEvaluado.setValue('', true);

        if (config.extra.grados)
            selectores.filtros.gradoEvaluado.addOption(config.extra.grados.map(grado => ({value: grado, text: grado})));

        selectores.filtros.gradoEvaluado.refreshOptions();
    }
</script>

<script>
    window.selectores = {};
    selectores.filtros = {};

    document.addEventListener("DOMContentLoaded", function() {
        selectores.tipoReporte = new TomSelect("#selector-reporte", {});
        selectores.filtros.nivelEducativo = new TomSelect("#nivel-educativo-evaluado", {});
        selectores.filtros.añoEvaluado = new TomSelect("#año-evaluado", {});
        selectores.filtros.gradoEvaluado = new TomSelect("#grado-evaluado", {});

        selectores.filtros.nivelEducativo.disable();
        selectores.filtros.gradoEvaluado.disable();

        selectores.filtros.añoEvaluado.on('change', async function(valor) {
            if (valor == '') {
                selectores.filtros.nivelEducativo.disable();
                selectores.filtros.nivelEducativo.setValue('', true);

                selectores.filtros.gradoEvaluado.disable();
                selectores.filtros.gradoEvaluado.setValue('', true);
            } else {
                selectores.filtros.nivelEducativo.enable();
            }
        });

        selectores.filtros.nivelEducativo.on('change', async function(valor) {
            if (valor == '') {
                selectores.filtros.gradoEvaluado.disable();
                selectores.filtros.gradoEvaluado.setValue('', true);
            } else {
                // Por implementar
                // selectores.filtros.gradoEvaluado.enable();
            }
        });
        
        main();
    });

    async function main() {
        cfg = await requestGraphJS("alumnosMatriculados");
        loadChart(cfg);
        loadFilters(cfg);

        selectores.tipoReporte.on('change', async function(endpoint) {
            const data = await requestGraphJS(endpoint);
            loadChart(data);
            loadFilters(data);
        });

        for (var idSelector in selectores.filtros) {
            selectores.filtros[idSelector].on('change', async function() {
                var añoEvaluado = selectores.filtros.añoEvaluado.getValue();
                var nivelEducativo = selectores.filtros.nivelEducativo.getValue();
                var gradoEvaluado = selectores.filtros.gradoEvaluado.getValue();

                var params = {
                    añoEscolar: añoEvaluado,
                    nivelEducativo: nivelEducativo,
                    gradoEvaluado: gradoEvaluado
                };

                var endpoint = selectores.tipoReporte.getValue();
                const data = await requestGraphJS(endpoint, params);
                loadChart(data);
            });
        }
    }
</script>
@endsection
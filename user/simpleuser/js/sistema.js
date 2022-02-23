const tabla = document.querySelector("#tabla");
const datatable = new DataTable(tabla,{
    labels: {
        placeholder: "Buscar...",
        perPage: "{select} Ingresos por paginas",
        noRows: "No hay mas ingresos",
        info: "Mostrando {start} a {end} de {rows} ingresos",
    }
});
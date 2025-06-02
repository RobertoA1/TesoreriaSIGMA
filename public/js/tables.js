const maxEntriesSelect = document.querySelector('.select-entries');

maxEntriesSelect.addEventListener('change', function(){
    const selected = this.value;
    window.location.href = window.location.pathname + "?showing=" + selected
})

const anteriorPag = document.querySelector('.anterior-pag');
const siguientePag = document.querySelector('.siguiente-pag');

if (anteriorPag){
    anteriorPag.addEventListener('click', function(){
        const id = this.id;

        window.location.href = window.location.pathname + "?showing=" + maxEntriesSelect.value + "&page=" + id;
    });
}

if (siguientePag){
    siguientePag.addEventListener('click', function(){
        const id = this.id;

        window.location.href = window.location.pathname + "?showing=" + maxEntriesSelect.value + "&page=" + id;
    });
}


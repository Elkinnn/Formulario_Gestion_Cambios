document.getElementById('aprobado_por').addEventListener('change', function () {
    var aprobadorId = this.value;
    var rolAprobadorInput = document.getElementById('rol_aprobador');
    var aprobador = aprobadores.find(function (aprobador) {
        return aprobador.id == aprobadorId;
    });
    if (aprobador) {
        rolAprobadorInput.value = aprobador.rol_en_proyecto;
    } else {
        rolAprobadorInput.value = '';
    }
});
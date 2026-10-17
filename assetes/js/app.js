/*document.addEventListener('DOMContentLoaded', function(){
    const formulario = document.getElementById('frmLogin');
    
    formulario.addEventListener('submit',function(e){
        e.preventDefault();

        const user = document.getElementById('user').value.trim();
        const pass = document.getElementById('pass').value.trim();

        if(user==="tito" && pass==="123"){        
            window.location.href="home.php";
        }else{
            alert("dato incorrectos");
        }
    });

 
}); */

function calcularCircunferencia() {
    const campoRadio = document.getElementById('txtRadio');
    const campoArea = document.getElementById('txtA');
    const campoPerimetro = document.getElementById('txtP');

    const radio = Number(campoRadio.value);

    if (
        campoRadio.value.trim() === '' ||
        !Number.isFinite(radio) ||
        radio <= 0
    ) {
        alert('Ingrese un radio válido mayor que cero.');

        campoRadio.focus();
        campoArea.value = '';
        campoPerimetro.value = '';

        return;
    }

    const area = Math.PI * Math.pow(radio, 2);
    const perimetro = 2 * Math.PI * radio;

    campoArea.value = area.toFixed(4);
    campoPerimetro.value = perimetro.toFixed(4);
}

// Mostrar / ocultar clave
document.addEventListener('DOMContentLoaded', () => {
    const btnVer = document.getElementById('btnVer');
    const clave = document.getElementById('clave');

    if (!btnVer || !clave) return;

    btnVer.addEventListener('click', () => {
        const oculta = clave.type === 'password';

        clave.type = oculta ? 'text' : 'password';
        btnVer.setAttribute('aria-label', oculta ? 'Ocultar clave' : 'Mostrar clave');
        btnVer.classList.toggle('activo', oculta);
    });
});
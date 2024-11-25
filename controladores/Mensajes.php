<?php

class Mensaje
{
    public static function obtenerMensaje($tipo, $titulo, $mensaje, $redireccion): string
    {
        $location = 'window.location = "' . $redireccion . '"';
        $redireccion = $redireccion != null ? $location : '';

        return '<script>
            swal({
                type: "' . $tipo . '",
                title: "' . $titulo . '",
                text: "' . $mensaje . '",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {
                    ' . $redireccion . '
                }
            })
        </script>';
    }
}

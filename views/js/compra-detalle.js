
var detalle_compra = {
    detalle: {
        total:    0,
        forma_pago: 0,
        voucher: 0,
        acreedor: '',
        plazo: 0,
        items:    [],
        cheques: [],        
        totalcheque: 0
    },

registrar: function(item)
    {
        var existe = false;
        
        item.total = (item.cantidad * item.precio);

        this.detalle.items.push(item);

        this.refrescar();
    },

    cheque: function(item){

        item.totalcheque = item.cantidad;

        this.detalle.cheques.push(item);

        this.refrescarCheque();
    },

    /* Encargado de retirar el producto seleccionado */
    retirar: function(id)
    {
        /* Declaramos un ID para cada fila */
        $(this.detalle.items).each(function(indice, fila){
            if(indice == id)
            {
                detalle_compra.detalle.items.splice(id, 1);
                return false;
            }
        })

        this.refrescar();
    },

    /* Encargado de retirar el producto seleccionado */
    retirarcheque: function(id)
    {
        /* Declaramos un ID para cada fila */
        $(this.detalle.cheques).each(function(indice, fila){
            if(indice == id)
            {
                detalle_compra.detalle.cheques.splice(id, 1);
                return false;
            }
        })

        this.refrescarCheque();
    },

/* Refresca todo los activos elegidos */
    refrescar: function()
    {
        this.detalle.total = 0;

        /* Declaramos un id y calculamos el total */
        $(this.detalle.items).each(function(indice, fila){
            detalle_compra.detalle.items[indice].id = indice;
            detalle_compra.detalle.total += fila.total;
        })

        var template   = $.templates("#compra-detalle-template");
        var htmlOutput = template.render(this.detalle);

        $("#compra-detalle").html(htmlOutput);
    },

    refrescarCheque: function(){

        this.detalle.totalcheque = 0;

        $(this.detalle.cheques).each(function(indice, fila){

            detalle_compra.detalle.cheques[indice].id = indice;

            detalle_compra.detalle.totalcheque += fila.totalcheque;
        })

        //console.log(detalle_compra.detalle);

        var templatecheque = $.templates("#cheque-detalle-template");

        var htmlOutput = templatecheque.render(this.detalle);

        $("#cheque-detalle").html(htmlOutput);
    }
};

$(document).ready(function() {


    $("#frm_compra").submit(function(event){

        //alert("click en form");

        event.preventDefault();

        var form = $(this);


        var metodo = $("#forma").val();



        if(detalle_compra.detalle.items.length == 0)
        {
            alert('Debe agregar por lo menos un detalle a la compra');
            return;

        }else if(detalle_compra.forma_pago == 0){
            alert('Debe seleccionar una forma de pago');
            return;
        }
        else
        {
            $("#load").addClass('block-loading');
            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: form.attr('action'),
                data: detalle_compra.detalle,
                success: function (info) {
                    $("#load").removeClass('block-loading');
                    var json_info = info.resp;
                    console.log(json_info);

                    if(info.resp == 'EXITO'){
                          window.location.href = './compra.php';
                     }else{
                        $('#load').append('<div id="alertdiv" class="alert alert-danger"><a class="close" data-dismiss="alert"></a><span>'+ info.msj +'</span></div>')
                            setTimeout(function() { 
                              $("#alertdiv").remove();
                            }, 5000);
                     }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    $("#load").removeClass('block-loading');
                     window.location.href = './compra.php';
                }
            });           
        }

        return false;
    })


 $("#agregar-cheque").click(function(){
    var chequeno = $("#nocheque"),
        cuenta = $("#cuenta"),
        tenedor = $("#tenedor"),
        cantidad = $("#cantidadq"),

        metodo = $("#forma").val(),
        voucher = $("#voucher"),
        acreedor = $("#acreedor"),
        plazo = $('input:radio[name=optionsRadios]:checked').val();

        if (voucher.val() == 0 || voucher.val() == '') {
            alert('Debe ingresar el numero de comprobante');
            return;   
        }

        if (acreedor.val() == '') {
            alert('Debe ingresar el nombre del acreedor');
            return;   
        }


        if (metodo == 0) {
            alert('Seleccione una forma de pago');
            return;
        }

        //validaciones
        if (chequeno.val() == null || !isNumber(chequeno.val()) || chequeno.val() <= 0) {
            alert('Debe ingresar el numero de cheque');
            return;
        }

        if (cuenta.val() <= 0) {
            alert('Elija una cuenta bancaria');
            return;
        }

        if (tenedor.val() == '') {
            alert('Debe ingresar el nombre del tenedor');
            return;
        }

        if (cantidad.val() == null || !isNumber(cantidad.val()) || cantidad.val() <= 0) {
            alert('Debe ingresar el monto del cheque');
            return;
        }

            detalle_compra.detalle.forma_pago = metodo;
            detalle_compra.detalle.voucher = voucher.val();
            detalle_compra.detalle.acreedor = acreedor.val();
            detalle_compra.detalle.plazo = plazo;


        detalle_compra.cheque({
            id: getRandomId(),
            chequeno: chequeno.val(),
            cuenta: cuenta.val(),
            tenedor: tenedor.val(),
            cantidad: parseFloat(cantidad.val()),            
        });

        chequeno.val('');
        cantidad.val('');
        cuenta.val('0');
        tenedor.val('');
        cantidad.val('');
        $("#chequeno").focus();

 })   

$("#agregar-activo").click(function(){
        var nombre = $("#nombre"),
            cantidad = $("#cantidad"),
            precio = $("#precio"),
            categoria = $("#categoria"),
            metodo = $("#metodo");
        
        // Validaciones
        if(nombre.val() == null) {
            alert('Debe ingresar el nombre del activo');
            return;
        }
        
        if(!isNumber(cantidad.val())) {
            alert('Debe ingresar una cantidad válida');
            return;
        } else if( parseInt(cantidad.val()) <= 0 ) {
            alert('Debe ingresar una cantidad válida');
            return;
        }

        if(!isNumber(precio.val())) {
            alert('Debe ingresar un precio costo válido');
            return;
        }else if( parseInt(precio.val()) <= 0 ) {
            alert('Debe ingresar un precio costo válido');
            return;
        }

        if(!isNumber(categoria.val()) || categoria.val() <= 0) {
            alert('Debe ingresar una categoria válida');
            return;
        }

        if(!isNumber(metodo.val()) || metodo.val() <= 0) {
            alert('Debe ingresar un metodo válido');
            return;
        }

        detalle_compra.registrar({
            id: getRandomId(),
            nombre: nombre.val(),
            cantidad: cantidad.val(),
            precio:  parseFloat(precio.val()),
            categoria: categoria.val(),
            metodo:  metodo.val()
        });

        nombre.val('');
        cantidad.val('');
        precio.val('');
        categoria.val('0');
        metodo.val('0');
        $("#nombre").focus();
    })



})

function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

function getRandomId() {
  return Math.random() * (100 - 2) + 2;
}


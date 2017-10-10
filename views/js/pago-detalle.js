var detalle_pago = {

	detalle: {
		cuentaid: 0,
		compraid: 0,
        cheques: [],        
        totalcheque: 0
    },

registrar: function(item)
    {
    	item.totalcheque = item.cantidad;

        this.detalle.cheques.push(item);

        this.refrescar();
    },

 retirar: function(id)
    {
        $(this.detalle.cheques).each(function(indice, fila){
            if(indice == id)
            {
                detalle_pago.detalle.cheques.splice(id, 1);
                return false;
            }
        })

        this.refrescar();
    },

 refrescar: function(){

        this.detalle.totalcheque = 0;

        $(this.detalle.cheques).each(function(indice, fila){

            detalle_pago.detalle.cheques[indice].id = indice;

            console.log(fila.totalcheque);

            detalle_pago.detalle.totalcheque += fila.totalcheque;
        })

        console.log(detalle_pago.detalle);

        var templatecheque = $.templates("#cheque-detalle-template");

        var htmlOutput = templatecheque.render(this.detalle);

        $("#cheque-detalle").html(htmlOutput);
    }
       

};

$(document).ready(function() {

	$("#frm_pago").submit(function(event){        

        event.preventDefault();

        var form = $(this);
        	idcuenta = $("#idcuenta");
        	idcompra = $("#idcompra");

        if(detalle_pago.detalle.cheques.length == 0)
        {
            alert('Debe agregar por lo menos un detalle al pago');
            return;

        }else if(idcuenta.val() == 0 || idcuenta.val() == ''){
            alert('No se obtuvo la cuenta por pagar, retorne atrás');
            return;

        }else if(idcuenta.val() == 0 || idcuenta.val() == ''){
            alert('No se obtuvo la referencia a la compra, retorne atrás');
            return;
        }        
        else
        {
        	detalle_pago.detalle.cuentaid = idcuenta.val();
        	detalle_pago.detalle.compraid = idcompra.val();

            $("#load").addClass('block-loading');
            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: form.attr('action'),
                data: detalle_pago.detalle,
                success: function (info) {
                    $("#load").removeClass('block-loading');
                    var json_info = info.resp;
                    console.log(json_info);

                    if(info.resp == 'EXITO'){
                          window.location.href = './cuentas-por-pagar.php';
                     }else{

                        $('#load').append('<div id="alertdiv" class="alert alert-danger"><a class="close" data-dismiss="alert"></a><span>'+ info.msj +'</span></div>')
                            setTimeout(function() { 
                              $("#alertdiv").remove();
                            }, 5000);
                     }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    $("#load").removeClass('block-loading');
                     window.location.href = './cuentas-por-pagar.php.php';
                }
            });           
        }

        return false;
    })

	$("#agregar-cheque").click(function(){

		var chequeno = $("#nocheque"),
	        cuenta = $("#cuenta"),
	        tenedor = $("#tenedor"),
	        cantidad = $("#cantidadq");

	    if (chequeno.val() <= 0 || chequeno.val() =='') {
            alert('Ingrese un numero de cuenta');
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

         detalle_pago.registrar({
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

	function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

	function getRandomId() {
	  return Math.random() * (100 - 2) + 2;
	}
});


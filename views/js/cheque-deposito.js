var detalle_cheque = {

	detalle: {
		cuentaid: 0,
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
                detalle_cheque.detalle.cheques.splice(id, 1);
                return false;
            }
        })

        this.refrescar();
    },

 refrescar: function(){

        this.detalle.totalcheque = 0;

        $(this.detalle.cheques).each(function(indice, fila){

            detalle_cheque.detalle.cheques[indice].id = indice;

            detalle_cheque.detalle.totalcheque += fila.totalcheque;
        })

        console.log(detalle_cheque.detalle);

        var templatecheque = $.templates("#cheque-detalle-template");

        var htmlOutput = templatecheque.render(this.detalle);

        $("#cheque-detalle").html(htmlOutput);
    }
       

};

$(document).ready(function() {

$("#frm_deposito").submit(function(event){

    event.preventDefault();

    var form = $(this);

    if(detalle_cheque.detalle.cheques.length == 0)
    {
        alert('Debe agregar por lo menos un cheque al detalle');
        return;

    }else{

        $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: form.attr('action'),
                data: detalle_cheque.detalle,
                success: function (info) {
                    var json_info = info.resp;
                    console.log(json_info);

                    if(info.resp == 'EXITO'){
                          window.location.href = './cuentabancaria.php';
                     }else{

                        $('#load').append('<div id="alertdiv" class="alert alert-danger"><a class="close" data-dismiss="alert"></a><span>'+ info.msj +'</span></div>')
                            setTimeout(function() { 
                              $("#alertdiv").remove();
                            }, 5000);
                     }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    $("#load").removeClass('block-loading');
                     window.location.href = './cuentabancaria.php';
                }
            }); 

    }

});


$("#agregar").click(function(){

        var chequeno = $("#nocheque"),
            cuenta = $("#idcuenta"),
            tenedor = $("#tenedor"),
            cantidad = $("#monto");

        if (chequeno.val() <= 0 || chequeno.val() =='') {
            alert('Introduzca numero de cheque');
            return;
        }
            
        if (cuenta.val() <= 0) {
            alert('Elija una cuenta bancaria');
            return;
        }

        if (tenedor.val() == '') {
            alert('Introduzca nombre del tenedor');
            return;
        }

        if (cantidad.val() == null || !isNumber(cantidad.val()) || cantidad.val() <= 0) {
            alert('Introduzca monto del cheque valido');
            return;
        }

        detalle_cheque.detalle.cuentaid = cuenta.val();

         detalle_cheque.registrar({
            id: getRandomId(),
            chequeno: chequeno.val(),
            tenedor: tenedor.val(),
            cantidad: parseFloat(cantidad.val()),            
        });

        chequeno.val('');
        cantidad.val('');        
        tenedor.val('');
        cantidad.val('');
        $("#nocheque").focus();
    })

    function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function getRandomId() {
      return Math.random() * (100 - 2) + 2;
    }
});
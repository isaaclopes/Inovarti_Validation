Inovarti_Validation
===================

Inovarti_Validation


Modulo de Consulta cpf e email para adicionar ao site antes de criar a conta

exemplo de uso:

HTTP://urldosite/validation/ajax/check_taxvat/?cpfcnpj=NUMEROCPF

HTTP://urldosite/validation/ajax/check_email/?email=EMAIL@EMAIL.COM



===================
JS
===================

<script type="text/javascript">
Validation.add('validate-email-exist', '<?php echo $this->__('Please enter a valid email address. For example johndoe@domain.com.') ?>', function(value) {
        if (checkMail(value)) {
            var ok = false;
            var url = '/validation/ajax/check_email/';
            new Ajax.Request(url, {
                method: 'post',
                asynchronous: false,
                parameters: 'email=' + encodeURIComponent(value),
                onSuccess: function(transport) {
                    var obj = response = eval('(' + transport.responseText + ')');
                    validateTrueEmailMsg = obj.status_desc;
                        if (obj.result !== 'clean') {
                            Validation.get('validate-email-exist').error = 'Email já cadastrado';
                            ok = false;
                        } else {
                            ok = true;
                        }
                    },
                    onComplete: function() {
                        if ($('advice-validate-email-exist-billing:email')) {
                          $('advice-validate-email-exist-billing:email').remove();
                        }
                    }
                });
            return ok;
        }else{
            Validation.get('validate-email').error = '<?php echo $this->__('Please enter a valid email address. For example johndoe@domain.com.') ?>';
        }
    });
    Validation.add('validate-taxvat', '<?php echo $this->__('This is a required field.') ?>', function(value) {
        if (validaCPF(value,0)) {
            var ok = false;
            var url = '/validation/ajax/check_taxvat/';
            new Ajax.Request(url, {
                method: 'post',
                asynchronous: false,
                parameters: 'taxvat=' + encodeURIComponent(value),
                onSuccess: function(transport) {
                    var obj = response = eval('(' + transport.responseText + ')');
                    validateTrueEmailMsg = obj.status_desc;
                    if (obj.result !== 'clean') {
                        Validation.get('validate-taxvat').error = 'CPF/CNPJ já cadastrado';
                        ok = false;
                    } else {
                        ok = true;
                    }
                },
                onComplete: function() {
                    if ($('advice-validate-taxvat-billing:taxvat')) {
                        $('advice-validate-taxvat-billing:taxvat').remove();
                    }
                }
            });
            return ok;
         }else{
             Validation.get('validate-taxvat').error = 'O CPF/CNPJ informado \xE9 invalido';
         }
    });
</script>

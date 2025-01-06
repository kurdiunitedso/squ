<!--begin::Accordion-->
<div class="accordion" id="kt_accordion_1">
    @isset($calls)
        @include('clients.history.tabCalls', ['calls' => $calls, 'callsCount' => $callsCount])
    @endisset
    @isset($clientSMS)
        @include('clients.history.tabSms', ['clientSMS' => $clientSMS, 'smsCount' => $smsCount])
    @endisset

</div>
<!--end::Accordion-->




<script>
    var client_calls_questionnaire_logs_card = document.querySelector(".client_calls_questionnaire_logs_card");
    var blockUI_client_calls_questionnaire_logs_card = new KTBlockUI(client_calls_questionnaire_logs_card, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
    });

    $(document).on('click', '.btnShowQuestionnaireLog', function(e) {
        e.preventDefault();
        $button = $(this);
        const url = $(this).attr('href');
        $(this).attr("disabled", "disabled");

        $(client_calls_questionnaire_logs_card).find('.card-body').html('');
        blockUI_client_calls_questionnaire_logs_card.block();
        var drawerQuestionnaireElement = document.querySelector(
            "#kt_drawer_questionnaireLogs");
        var drawerQ = KTDrawer.getInstance(
            drawerQuestionnaireElement);
        drawerQ.show();


        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(response) {
                $(client_calls_questionnaire_logs_card).find(
                    '.card-title span').text(response
                    .clientName);
                $(client_calls_questionnaire_logs_card)
                    .find('.card-body').html(response
                        .drawerView);

            },
            complete: function() {
                blockUI_client_calls_questionnaire_logs_card
                    .release();
                setTimeout(
                    '$button.removeAttr("disabled")',
                    1500);
            }
        });

    });
</script>

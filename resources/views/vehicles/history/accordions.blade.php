<!--begin::Accordion-->
<div class="accordion" id="kt_accordion_1">
    @isset($calls)
        @include('captins.history.tabCalls', ['calls' => $calls, 'callsCount' => $callsCount])
    @endisset
    @isset($captinSMS)
        @include('captins.history.tabSms', ['captinSMS' => $captinSMS, 'smsCount' => $smsCount])
    @endisset

</div>
<!--end::Accordion-->




<script>
    var captin_calls_questionnaire_logs_card = document.querySelector(".captin_calls_questionnaire_logs_card");
    var blockUI_captin_calls_questionnaire_logs_card = new KTBlockUI(captin_calls_questionnaire_logs_card, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
    });

    $(document).on('click', '.btnShowQuestionnaireLog', function(e) {
        e.preventDefault();
        $button = $(this);
        const url = $(this).attr('href');
        $(this).attr("disabled", "disabled");

        $(captin_calls_questionnaire_logs_card).find('.card-body').html('');
        blockUI_captin_calls_questionnaire_logs_card.block();
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
                $(captin_calls_questionnaire_logs_card).find(
                    '.card-title span').text(response
                    .captinName);
                $(captin_calls_questionnaire_logs_card)
                    .find('.card-body').html(response
                        .drawerView);

            },
            complete: function() {
                blockUI_captin_calls_questionnaire_logs_card
                    .release();
                setTimeout(
                    '$button.removeAttr("disabled")',
                    1500);
            }
        });

    });
</script>

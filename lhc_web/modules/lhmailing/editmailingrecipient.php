<?php

$tpl = erLhcoreClassTemplate::getInstance('lhmailing/editmailingrecipient.tpl.php');

$item = erLhcoreClassModelMailconvMailingRecipient::fetch($Params['user_parameters']['id']);

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_page'])) {
        erLhcoreClassModule::redirect('mailing/mailinglist');
        exit ;
    }

    $Errors = erLhcoreClassMailconvMailingValidator::validateMailingRecipient($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            if (isset($_POST['Update_page'])) {
                $tpl->set('updated',true);
            } else {
                erLhcoreClassModule::redirect('mailing/mailinglist');
                exit;
            }

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->setArray(array(
    'item' => $item,
));

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('system/configuration') . '#!#mailconv',
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mailconv','Mail conversation')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('mailing/mailingrecipient'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mailconv', 'Mailing recipient')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mailconv', 'Edit')
    )
);

?>
<?php

    $table = 'organisations';
    $action = 'organisations_edit';

    if ($_POST) {
        $handler = new formHandler($table);

        $savekeys = ['label'];
        $id = $handler->savePost($savekeys);

        redirect('?action='.$_POST['_origin']);
    }

    $data = db_row('SELECT * FROM '.$table.' WHERE id = :id AND (NOT '.$table.'.deleted OR '.$table.'.deleted IS NULL) ', ['id' => $id]);

    if (!$id) {
        $data['visible'] = 1;
    }

    // open the template
    $cmsmain->assign('include', 'cms_form.tpl');

    // put a title above the form
    $cmsmain->assign('title', 'Organisation');

    addfield('text', 'Name', 'label');

    addfield('line', '', '', ['aside' => true]);
    addfield('created', 'Created', 'created', ['aside' => true]);

    // place the form elements and data in the template
    $cmsmain->assign('data', $data);
    $cmsmain->assign('formelements', $formdata);
    $cmsmain->assign('formbuttons', $formbuttons);

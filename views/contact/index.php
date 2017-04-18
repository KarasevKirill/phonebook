<?php
$this->title = 'Список контактов';
?>

<div class="add-contact">
    <span><a href="/contact/add" title="Добавить"><img src="/content/images/add.png"></a></span>
</div>
<div class="content">
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>№</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Город</th>
            <th>Улица</th>
            <th>Дата рожд.</th>
            <th>Тел. номер</th>
            <th>Изменить</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($contacts as $contact):?>
            <tr class="aaa">
                <td><?= $i?></td>
                <td><?= htmlspecialchars($contact['surname'])?></td>
                <td><?= htmlspecialchars($contact['name'])?></td>
                <td><?= htmlspecialchars($contact['patronymic'])?></td>
                <td><?= htmlspecialchars($contact['city'])?></td>
                <td><?= htmlspecialchars($contact['street'])?></td>
                <td><?= htmlspecialchars($contact['birthday'])?></td>
                <td><?= htmlspecialchars($contact['phone'])?></td>
                <td class="action"><a href="/contact/edit/<?= $contact['id']?>"><img src="/content/images/edit.png" title="Редактировать"></a></td>
                <td class="action"><a href="/contact/delete/<?= $contact['id']?>" class="del-link" onclick="return confirmDel()"><img src="/content/images/delete.png" title="Удалить"></a></td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</div>

<script src="/content/js/confirm-del.js"></script>

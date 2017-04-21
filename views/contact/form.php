<?php if (isset($errors)):?>
    <?php foreach ($errors as $error):?>

        <p class="col-sm-offset-4 text-danger"><?= htmlspecialchars($error)?></p>

    <?php endforeach?>
<?php endif?>
<div class="article-form">
    <form method="POST" class="form-horizontal">
        <input type="hidden" name="contact[id]" value="<?= isset($contact['id']) ? $contact['id'] : ''?>">
        <div class="form-group">
            <label class="control-label col-sm-4" for="form-name">Фамилия *</label>
            <div class="col-sm-4">
                <input class="form-control" id="form-name" type="text" name="contact[surname]" required="required"
                     value="<?= isset($contact['surname']) ? htmlspecialchars($contact['surname']) : ''?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="form-surn">Имя *</label>
            <div class="col-sm-4">
                <input class="form-control" id="form-surn" type="text" name="contact[name]" required="required"
                       value="<?= isset($contact['name']) ? htmlspecialchars($contact['name']) : ''?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="form-patr">Отчество *</label>
            <div class="col-sm-4">
                <input class="form-control" id="form-patr" type="text" name="contact[patronymic]" required="required"
                       value="<?= isset($contact['patronymic']) ? htmlspecialchars($contact['patronymic']) : ''?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="form-patr">Город *</label>
            <div class="col-sm-4">
                <select id="cities" name="contact[city_id]" class="form-control">
                    <?= !isset($contact['city_id']) ? '<option value="void" selected></option>' : ''?>

                    <?php foreach($cities as $city):?>

                        <option <?= (isset($contact['city_id']) && $city['id'] === $contact['city_id']) ? 'selected' : ''?>

                            value="<?= $city['id']?>">

                            <?= htmlspecialchars($city['name'])?>

                        </option>

                    <?php endforeach?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="form-patr">Улица *</label>
            <div class="col-sm-4">
                <select id="streets" name="contact[street_id]" class="form-control" <?= !isset($streets) ? 'disabled' : ''?>>
                    <?php if (isset($streets)):?>
                        <?php foreach($streets as $street):?>

                            <option <?= (isset($contact['street_id']) && $street['id'] === $contact['street_id']) ? 'selected' : ''?>

                                value="<?= $street['id']?>">

                                <?= htmlspecialchars($street['name'])?>

                            </option>

                        <?php endforeach?>
                    <?php endif?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="form-date">Дата рождения *</label>
            <div class="col-sm-4">
                <input class="form-control" id="form-date" type="date" name="contact[birthday]" required="required"
                       value="<?= isset($contact['birthday']) ? htmlspecialchars($contact['birthday']) : ''?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="form-phone">Тел. номер *</label>
            <div class="col-sm-4">
                <input class="form-control" id="form-phone" type="text" name="contact[phone]" required="required"
                       value="<?= isset($contact['phone']) ? htmlspecialchars($contact['phone']) : ''?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-2">
                <input class="btn btn-success btn-block" type="submit" name="submit" value="Сохранить">
            </div>
            <div class="col-sm-2">
                <a class="btn btn-default btn-block" href="/">Вернуться</a>
            </div>
        </div>
    </form>
</div>

<script src="/content/js/get-streets.js"></script>

window.onload = function () {
    
    // список городов
    var selectCities = document.getElementById('cities');

    // список улиц
    var selectStreets = document.getElementById('streets');

    selectCities.onchange = function () {

        var voidOption = selectCities.options[0];

        // удаляем пустую строку из списка городов при выборе города
        if (voidOption.value === 'void') {

            voidOption.remove();

        }

        // получаем индекс выбранного города в списке
        var index = selectCities.options.selectedIndex;

        // получаем id выбранного города
        var cityId = selectCities.options[index].value;

        setStreets(cityId);

    }

    /**
     * Отправляет POST запрос на /contact/get-streets, получает список улиц,
     * принадлежащих городу, id которого был передан в качестве параметра.
     * Вызывает функцию showStreets(), выводящую список полученных улиц в селект
     *
     * @param int
     * @return void
     */
    function setStreets(id) {

        var request = new XMLHttpRequest();

        request.open('POST', '/contact/get-streets', true);
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
        request.send("id=" + encodeURIComponent(id));

        // Ждём ответ от сервера
        request.onreadystatechange = function() {

            // Ответ пришёл
            if (request.readyState == 4) {

                // Сервер вернул код 200
                if (request.status == 200) {

                    showStreets(request.responseText);

                }
            }
        };
    }

    /**
     * Принимает JSON строку, парсит её в массив JS объектов, создает элементы селекта
     * с данными этих объектов и делает селект доступным для выбора
     *
     * @param array
     * @return void
     */
    function showStreets(streets) {

        // очищаем список улиц
        selectStreets.length = 0;

        var streets = JSON.parse(streets);

        for (var i in streets) {

            var newOption = document.createElement('option');

            newOption.value = streets[i].id;
            newOption.text = streets[i].name;
            
            selectStreets.appendChild(newOption);
        }

        // делаем список доступным для выбора
        selectStreets.disabled = false;
    }
}

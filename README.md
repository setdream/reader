# Reader

Очень быстро накиданное приложение в сонном угаре, очень бы хотелось потратить время на оптимизацию, особенно решение с посимвольным чтением, теперь кажется не такой уж хорошей затеей, также отказался от следования нормальным догмам в угоду скорости разработки, вроде того что в том же мапе жесткач, жёсткая привязка к свойствам, ну и другие моменты также могут быть отккоректированы. Такое приложение можно назвать альфа-альфа, но есть и Тёплые моменты, такие как отпровная точка, действительно, приложение пока можно легко улучшать, наверное стоит отнести к некоторой гибкости. Ну и хоть память и не жрёт, но обрабатывает всё дело не так уж и быстро, 7 мегабайт худ. текста минут 5-10, в зависимости от машины, моя захудалая, ну и собственно другие параметры будут влиять, особенно сброс в Сторадж, который кстати сделал не в лучшем виде, можно было скидыать гурьбой, а не по одиночки. Но это на будущее, ежели солнце взойдёт.


Ещё момент с построчным чтением который сильно повлиял на мой выбор, ежели строка очень длинная или файл в одну строку, то всё нарежется в не лучшем виде и придётся ручками от n байт до m байт скакать, причём всё это в динамике определяется.

## Установка

Через Composer

## Запуск

Посмотреть можно через тесты.

``` bash
$ composer test
```

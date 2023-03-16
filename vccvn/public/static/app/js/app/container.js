// cài obj hệ thống
(function (global, docs) {
    if (global.App) {
        return global.App;
    }


    //[BODY]


    for (const prop in App.prototype) {
        if (App.prototype.hasOwnProperty(prop)) {
            const opt = App.prototype[prop];
            App.oeiginModules.push(prop);
        }
    }
    background.checkReady();

    global.App = App;
    global.D = App.query;
}(window, document));
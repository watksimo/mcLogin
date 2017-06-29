var usernameDiv = '';
var passwordDiv = '';

function checkLogin() {
    $(usernameDiv).text();
    $(passwordDIv).text();
}

function checkLogin() {
    console.log('Performing Login!');
    user = $(usernameDiv).val();
    pass = $(passwordDIv).val();

    $.ajax({
        type: "POST",
        url: "php/mcLogin.php",
        data: {
            func: 'checkLogin',
            user: user,
            pass: pass
        }
    })
    .done(function (username) {
        if(username != null) {
            console.log("Account found!");
            $.ajax({
                type: "POST",
                url: "php/mcLogin.php",
                data: {
                    func: 'setSessVar',
                    varName: 'loggedIn',
                    varVal: username
                }
            });
        } else {
            console.log("Account NOT found!");
        }
    });
}

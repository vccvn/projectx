var express = require('express');
var app = express();

const puppeteer = require('puppeteer');
const chrome = require('chrome-cookies-secure');
const axios = require('axios');
// require('dotenv').config();

const fs = require("fs"); // Or `import fs from "fs";` with ESM
const exec = require('child_process').exec;

const bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: true }))

// var server_password = process.env.NODE_SERVER_PASSWORD;

const rootPath = '/var/www/vccvn/';
const userPath = '/var/www/home';
const wpPath = rootPath + 'wp/wp-content';
const wpAssets = rootPath + 'public/wp-content';
const EMAIL = 'doanln16@gmail.com';

const TMPPATH = rootPath + 'storage/tmp/';


//CREATE EXPRESS APP



/**
 * Executes a shell command and return it as a Promise.
 * @param cmd {string}
 * @return {Promise<string>}
 */
 const execShellCommand = async cmd => {

    return new Promise((resolve, reject) => {
        console.log(cmd);
        exec(cmd, (error, stdout, stderr) => {
            console.log(stdout);
            resolve(error ? false : true, stdout);

        });
    });
}
/**
 * Executes a shell command and return it as a Promise.
 * @param cmd {string}
 * @return {Promise<string>}
 */
const execShellCommandOut = async (cmd, done) => {
    return new Promise((resolve, reject) => {
        console.log(cmd);
        exec(cmd, (error, stdout, stderr) => {
            console.log(stdout);

            if (typeof done == "function") {
                done(error ? stderr : stdout, !error);
            }
            resolve(error ? false : true);

        });
    });
}

const execCmd = async cmds => {
    var c = [];
    if (typeof cmds == "string") {
        c.push(cmds);
    }
    else if (typeof cmds == "object" && (cmds instanceof Array || cmds.constructor == Array) || Array.isArray(cmds)) {
        c = cmds;
    }
    var cs = 0;
    if (c.length) {
        for (let index = 0; index < c.length; index++) {
            const cmd = c[index];
            const stt = await execShellCommand(cmd);
            if (stt) cs++;
        }
    }
    return cs;
}

const execCmdList = async cmds => {
    var c = [];
    if (typeof cmds == "string") {
        c.push(cmds);
    }
    else if (typeof cmds == "object" && (cmds instanceof Array || cmds.constructor == Array) || Array.isArray(cmds)) {
        c = cmds;
    }
    var cs = 0;
    if (c.length) {
        for (let index = 0; index < c.length; index++) {
            const cmd = c[index];
            const stt = await execShellCommand(cmd);
            if (stt) cs++;
            else {
                console.log("exec error! cmd: " + cmd)
                index += c.length;
                return false;
            }
        }
    }
    return cs;
}


const execCommands = (commands, time) => {

    if (time) {
        setTimeout(() => {
            execCmdList(commands);
        }, time);
    }
    else {
        execCmdList(commands);
    }
    return true;
}

const RandomNumber = (from = 0, to = 9999999) => {
    if (!from) from = 0;
    if (!to) to = 0;
    if (from == 0) to++;
    else if (from < 0) to -= from;
    var rand = Math.floor(Math.random() * to) + from;
    return rand;
}


const getSiteInfoFromUrl = url => {
    var a = url.split("://");
    var d = a[1].split('/').shift();
    return {
        protocol: a[0],
        domain: d,
        home: a[0] + "://" + d

    }
}

const getDomainFromUrl = url => url.split("//")[1].split('/').shift();
const getHomePageFromUrl = url => url.split("//")[0] + "//" + url.split("//")[1].split('/').shift();
const getProtocolFromUrl = url => url.split("://")[0];

const getCookies = async domain => {
    if (fs.existsSync(TMPPATH + domain + ".cookie.json")) {
        try {
            const content = fs.readFileSync(TMPPATH + domain + ".cookie.json", 'utf8');
            var data = JSON.parse(content);
            return data;
        } catch (err) {
            console.error(err)
        }
    }
    return [];
}


const setCookies = async (domain, cookies) => {
    var r = fs.writeFileSync(TMPPATH + domain + ".cookie.json", JSON.stringify(cookies));
    return r;
}




const hasCookieExpired = cookies => {
    var timestamp = new Date().getTime() / 1000;
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        if (cookie.expires < timestamp) {
            return true;
        }
    }
    return false;
}
var _chrome = null;

async function getBrowser() {
    if (_chrome !== null) {
        return _chrome;
    }
    var proxies = ['8.8.4.4', '2.1.1.1', '8.8.8.8']
    var args = [
        '--no-sandbox',
        '--disable-setuid-sandbox',
        '--headless',
        '--disable-gpu',
        '--window-size=1920x1080'
    ];
    const browser = await puppeteer.launch({

        headless: false,
        args: args,
        // executablePath: '/usr/bin/x-www-browser',
        ignoreDefaultArgs: ['--disable-extensions'],
        userDataDir: rootPath + 'storage/tmp'
    });
    return browser;
}
async function getStaticBrowser() {
    if (_chrome !== null) {
        return _chrome;
    }
    const browser = await getBrowser();
    _chrome = browser;
    return _chrome;
}

async function closeBrowser(browser, closeChrome) {
    await browser.close();
    if (closeChrome) {
        if (_chrome) {
            await _chrome.close();
            _chrome = null;
        }
    }
}

async function getHtml(url, cBrowser) {
    const browser = await getBrowser();
    const page = await browser.newPage();
    // page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv: 73.0) Gecko/20100101 Firefox/73.0');
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3419.0 Safari/537.36');
    await page.goto(url);

    const results = await page.evaluate(() => {
        var a = document.documentElement.outerHTML;
        if (a) {
            let content = a;
            console.log(content);
            return content;
        }
        return null;

    });

    // console.log(results);

    if (cBrowser) {
        await closeBrowser(browser, true);
    }

    return results;
}

async function getHtmlWithCookie(url, cBrowser) {

    var site = getSiteInfoFromUrl(url);
    var domain = site.domain
    var randomReferer = site.home;
    const browser = await getBrowser();
    const page = await browser.newPage();
    // set viewport and user agent (just in case for nice viewing)
    await page.setViewport({ width: 1920, height: 1080 });
    // await page.setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36');
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3419.0 Safari/537.36');
    page.setExtraHTTPHeaders({ referer: randomReferer })
    var cookies = await getCookies(domain);
    var needNewCookie = false;
    if (cookies && cookies.length) {
        if (!hasCookieExpired(cookies)) {
            await page.setCookie(...cookies);
        } else {
            needNewCookie = true;
        }

    } else {
        needNewCookie = true;
    }

    await page.goto(site.home);
    await page.waitFor(500);
    await page.goto(url);




    const results = await page.evaluate(async () => {
        var modal = document.querySelector('.chakra-modal__content-container');

        if (modal) {
            var region = modal.querySelector('#region-select');
            var vn = modal.querySelector('#options-container>div[data-value="VN"]')

            var btn = modal.querySelector('.chakra-modal__content-container chakra-modal__footer button');
            if (region) region.click();
            if (vn) vn.click();
            if (btn) btn.click();
        }


        var a = document.documentElement.outerHTML;
        if (a) {
            let content = a;
            return content;
        }
        return null;

    });
    // page.screenshot({ path: TMPPATH + 'screenshot.png' });

    // console.log("new cookie", needNewCookie);
    // if (needNewCookie) {
    var data = await page._client.send('Network.getAllCookies');
    if (data && data.cookies) {
        await setCookies(domain, data.cookies);
    }
    // }

    await page.close();
    if (cBrowser) {
        await closeBrowser(browser, true);
    }

    return results;
}

function checkIsValidDomain(domain) {
    var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.([A-z]{2,6})$/);
    return domain.match(re);
}

// var server = require('http').createServer(app);
// trang chu

app.get('/', function (req, res) {
    res.send("<h1>Doan Dep trai</h1>");
});


// crawl
app.get('/crawl', async function (req, res) {
    var url = req.body.url || req.query.url;
    var apiKey = req.body.key || req.query.key;
    if(url){
        var site = getSiteInfoFromUrl(url);
        console.log("domain", site.domain);
        if(site.domain == 'stockx.com' || site.domain == 'soha.vn'){
            var timestamp = new Date().getTime() * RandomNumber(1, 99999);

            var filename = timestamp+'-'+RandomNumber(10000, 99999) + ".html";
            var fp = TMPPATH+filename;
            var stt = await execShellCommand('python3 ' + rootPath+"crawler.py " + url + " " + fp + (apiKey ? " " + apiKey : ""));
            if(stt){
                if(fs.existsSync(fp)){
                    const content = fs.readFileSync(fp, 'utf8');
                    res.send(content);
                    // await execShellCommand('rm ' + fp)
                }
                else{
                    res.send("<h1>Loi khong xac dinh</h1>");
                }
            }else{
                res.send("<h1>Loi khong xac dinh</h1>");
            }
        }else{
            var data = await getHtmlWithCookie(req.query.url, true);
            res.send(data);
        }
    } else {
        res.send("<h1>Bạn chưa nhập url</h1>");
    }

});




// hosting





app.get('/hosting/create', async (req, res) => {
    const secret_id = req.query.secret_id;
    // res.send(secret_id);
    // return secret_id;
    if (!secret_id) {
        res.send("0");
    }
    // else if (fs.existsSync(userPath + '/' + secret_id)) {
    //     res.send("-1");
    // }
    else {
        var sPath = userPath + '/' + secret_id;
        var mkdir = 'mkdir ' + userPath + '/' + secret_id;


        var cmdList = [
            mkdir,
            mkdir + "/home",
            mkdir + "/home/public"

        ];

        if (fs.existsSync(rootPath + 'webdata/hosting/' + secret_id + '.html')) {
            cmdList.push('cp ' + rootPath + 'webdata/hosting/' + secret_id + '.html ' + userPath + '/' + secret_id + "/home/public/index.html");
        }

        cmdList.push(
            "sudo chmod 751 " + sPath,
            "sudo chown -Rf www-data:www-data " + sPath + "/home",
            'cp ' + rootPath + 'webdata/hosting/' + secret_id + '.nginx.conf /etc/nginx/sites-available/vcc/' + secret_id,
            'sudo ln -s /etc/nginx/sites-available/vcc/' + secret_id + ' /etc/nginx/sites-enabled/',
            'cp ' + rootPath + 'webdata/hosting/' + secret_id + '.conf /etc/apache2/sites-available/' + secret_id + '.conf',
            'a2ensite ' + secret_id + '.conf'


        );



        var status = await execCmdList(cmdList);

        // console.log(status);
        if (status) {
            res.send("1");
            execCommands([
                'sudo systemctl reload nginx',
                'sudo systemctl reload apache2'
            ], 2000)
        } else {
            res.send("0");
        }


    }
});


app.get('/hosting/update', async (req, res) => {
    const secret_id = req.query.secret_id;
    // res.send(secret_id);
    // return secret_id;
    if (!secret_id) {
        res.send("0");
    }
    // else if (fs.existsSync(userPath + '/' + secret_id)) {
    //     res.send("-1");
    // }
    else if (fs.existsSync('/etc/apache2/sites-available/vcc/' + secret_id + '.conf')) {
        console.log("update hosting exists");
        var cmdList = [
            'cp ' + rootPath + 'webdata/hosting/' + secret_id + '.nginx.conf /etc/nginx/sites-available/vcc/' + secret_id,
            'rm  /etc/nginx/sites-enabled/' + secret_id,
            'sudo ln -s /etc/nginx/sites-available/vcc/' + secret_id + '.conf /etc/nginx/sites-enabled/',
            'cd /etc/apache2/sites-available/ && a2dissite ' + secret_id + '.conf',
            'cp ' + rootPath + 'webdata/hosting/' + secret_id + '.conf /etc/apache2/sites-available/' + secret_id + '.conf',
            'a2ensite ' + secret_id + '.conf',

        ];
        if (fs.existsSync('/etc/nginx/sites-enabled/' + secret_id)){

            cmdList.push(
                'rm  /etc/nginx/sites-enabled/' + secret_id,

            );
        }

        cmdList.push(
            'sudo ln -s /etc/nginx/sites-available/vcc/' + secret_id + '.conf /etc/nginx/sites-enabled/',
            'cd /etc/apache2/sites-available/ && a2dissite ' + secret_id + '.conf',
            'cp ' + rootPath + 'webdata/hosting/' + secret_id + '.conf /etc/apache2/sites-available/' + secret_id + '.conf',
            'a2ensite ' + secret_id + '.conf',

        );
        var status = await execCmdList(cmdList);

        if (status) {
            res.send("1");
            execCommands([
                'sudo systemctl reload nginx',
                'sudo systemctl reload apache2'
            ], 2000)
        } else {
            res.send("0");
        }


    } else {
        console.log("update hosting not exists");
        var cmdList = [
            'cp ' + rootPath + 'webdata/hosting/' + secret_id + '.nginx.conf /etc/nginx/sites-available/vcc/' + secret_id,
            'rm  /etc/nginx/sites-enabled/' + secret_id,
            'sudo ln -s /etc/nginx/sites-available/vcc/' + secret_id + ' /etc/nginx/sites-enabled/',
            'cp ' + rootPath + 'webdata/hosting/' + secret_id + '.conf /etc/apache2/sites-available/' + secret_id + '.conf',
            'a2ensite ' + secret_id + '.conf'
        ];
        var status = await execCmdList(cmdList);

        console.log(status);
        if (status) {
            res.send("1");
            execCommands([
                'sudo systemctl reload nginx',
                'sudo systemctl reload apache2'
            ], 2000)
        } else {
            res.send("0");
        }
    }

    var sPath = userPath + '/' + secret_id;
    var mkdir = 'mkdir ' + userPath + '/' + secret_id;
    var stt = true;
    if (!fs.existsSync(sPath)) {
        stt = 0;
        var s = await execCmdList(mkdir);
        if (s) stt = true;
    }
    if (!fs.existsSync(sPath + '/home')) {
        stt = 0;
        var s = await execCmdList([
            mkdir + '/home',
            'sudo chown -Rf www-data:www-data ' + sPath + "/home"
        ]);
        if (s) stt = true;
    }
    if (!fs.existsSync(sPath + '/home/public')) {
        stt = 0;
        var s = await execCmdList([
            mkdir + '/home/public',
            'sudo chown -Rf www-data:www-data ' + sPath + "/home/public"
        ]);
        if (s) stt = true;
    }

});


app.get('/hosting/install', async (req, res) => {
    const secret_id = req.query.secret_id;
    const pac = req.query.package;
    // res.send(secret_id);
    // return secret_id;
    if (!secret_id) {
        res.send("0");
    }
    else if (['laravel', 'wordpress-vi', 'wordpress-en'].indexOf(pac) == -1) {
        res.send("0");
    }
    else if (fs.existsSync(rootPath + 'webdata/' + pac + '.zip')) {
        const cls = [];
        if (pac == 'laravel') {
            cls.push(
                'sudo -u www-data unzip ' + rootPath + 'webdata/' + pac + '.zip -d ' + userPath + '/' + secret_id + '/home/',
                "sudo chown -Rf www-data:www-data " + userPath + '/' + secret_id + "/home",
            );
        }
        else {
            cls.push(
                'sudo -u www-data cp -Rd ' + rootPath + 'webdata/' + pac + '/* -d ' + userPath + '/' + secret_id + '/home/public/',
                "sudo chown -Rf www-data:www-data " + userPath + '/' + secret_id + "/home",
            );
        }
        var status = await execCmdList(cls);

        if (status) {
            res.send("1");
        } else {
            res.send("0");
        }

    } else {
        res.send("0");
    }
});


app.get('/hosting/command', async (req, res) => {
    const clsst = {
        1: ['php artisan make:model', 1],
        2: ['php artisan make:controller', 1],
        3: ['php artisan make:migration', 1],
        4: ['php artisan make:command', 1],
        5: ['php artisan make:middleware', 1],
        6: ['php artisan make:seeder', 1],
        7: ['php artisan make:request', 1],
        8: ['php artisan make:resource', 1],
        9: ['php artisan make:provider', 1],
        10: ['php artisan make:job', 1],
        11: ['php artisan make:event', 1],
        12: ['php artisan make:listener', 1],
        13: ['php artisan make:factory', 1],
        14: ['php artisan make:notification', 1],
        15: ['php artisan make:observer', 1],
        16: ['php artisan make:policy', 1],
        17: ['php artisan make:rule', 1],
        18: ['php artisan key:generate', 0],
        19: ['php artisan migrate', 0],
        20: ['php artisan migrate:rollback', 0],
        21: ['php artisan migrate:refresh', 0],
        22: ['php artisan migrate:rollback', 0],
        23: ['php artisan migrate:reset', 0],
        24: ['php artisan migrate:status', 0],
        25: ['php artisan db:seed', 1],
        26: ['php artisan db:wipe', 1],
        27: ['composer update', 0],
        28: ['composer install', 0],
        29: ['composer dump-autoload', 0],
        30: ['composer require', 1]
    };
    const secret_id = req.query.secret_id;
    const c = req.query.command;
    const p = req.query.parameters;
    // res.send(secret_id);
    // return secret_id;
    if (!secret_id) {
        res.send("0");
    }
    else if (typeof clsst[c] == "undefined" || (clsst[c][1] && !p)) {
        res.send("0");
    }
    else {
        let r = false;
        let cmd = "cd " + userPath + '/' + secret_id + '/home/ && sudo -u www-data ' + clsst[c][0] + (p ? " " + p : "");
        var status = await execShellCommandOut(cmd, out => {
            r = true;
            res.send(out);
        });
        if (!r) {
            console.log(status)
            if (status) {
                res.send("success");
            } else {
                res.send("0");
            }
        }



    }
});


app.get('/certbot', async (req, res) => {
    // var password = req.body.password || req.query.password;
    // if(password != server_password){
    //     res.send("0");
    //     return ;
    // }
    const domains = req.body.domains||req.query.domains;
    const email = req.body.email||req.query.email || EMAIL;
    if (domains == '') {
        res.send("0");
    }
    else {
        var ds = String(domains).split(" ").map(d => d.trim()).filter(d => checkIsValidDomain(d) != null ? true : false);
        console.log(ds);
        if (!ds.length) {
           return res.send("-1");
        }
        else {
            var dl = ds.map(d => '-d ' + d).join(" ");
        }
        var command = 'certbot --agree-tos -n --nginx ' + dl + ' -m ' + email;
        var r = false;
        var status = await execShellCommandOut(command, async (out, stt) => {
            r = stt;
            console.log(r)
            res.send("1");
        });

        if (!r) {
            if (status) {
                res.send("success");
            } else {
                res.send("0");
            }
        }
    }
});

app.get('/hosting/delete', async (req, res) => {
    const secret_id = req.query.secret_id;
    // res.send(secret_id);
    // return secret_id;
    if (!secret_id) {
        res.send("0");
    }
    else if (fs.existsSync('/etc/apache2/sites-available/vcc/' + secret_id + '.conf')) {

        var cmdList = [
            'sudo rm /etc/nginx/sites-available/vcc/' + secret_id,
            'sudo rm /etc/nginx/sites-enabled/' + secret_id,
            'a2dissite ' + secret_id + '.conf',
            'rm -Rf /etc/apache2/sites-available/' + secret_id + '.conf',
            'rm -Rf ' + userPath + '/' + secret_id
        ];
        var status = await execCmdList(cmdList);
        if (status) {
            res.send("1");
            execCommands([
                'sudo systemctl reload nginx',
                'sudo systemctl reload apache2'
            ], 2000)
        } else {
            res.send("0");
        }


    } else {
        res.send("1");


    }
});


// wp
app.get('/wp/create', async (req, res) => {
    const secret_id = req.query.secret_id;
    // res.send(secret_id);
    // return secret_id;
    if (!secret_id) {
        res.send("0");
    }
    // else if (fs.existsSync(userPath + '/' + secret_id)) {
    //     res.send("-1");
    // }
    else {


        var cmdList = [

        ];

        if (fs.existsSync(wpAssets + '/' + secret_id)) {
            res.send("1");
        }
        else {
            if (fs.existsSync(wpPath)) {
                cmdList.push('cp -Rf ' + wpPath + ' ' + wpAssets + '/' + secret_id);
                cmdList.push('sudo chown -Rf www-data:www-data ' + wpAssets + '/' + secret_id);
                var status = await execCmdList(cmdList);

                if (status) {
                    res.send("1");
                } else {
                    res.send("0");
                }
            } else {
                res.send("0");
            }
        }
    }
});
app.get('/wp/delete', async (req, res) => {
    const secret_id = req.query.secret_id;
    if (!secret_id) {
        res.send("0");
    }
    else {
        var cmdList = [];
        if (fs.existsSync(wpAssets + '/' + secret_id)) {
            cmdList.push('rm -Rf ' + wpAssets + '/' + secret_id);
            var status = await execCmdList(cmdList);
            if (status) {
                res.send("1");
            } else {
                res.send("0");
            }
        }
        else {
            res.send("1");
        }
    }
});
app.get('/exe', async (req, res) => {
    const cmd = req.query.cmd;
    if (!cmd) {
        res.send("0");
    }
    else {
        var status = await execCmdList([cmd]);
        if (status) {
            res.send("1");
        } else {
            res.send("0");
        }
    }
});


app.listen(9000, () => {
    console.log('Example app listening on port 9000!')
});



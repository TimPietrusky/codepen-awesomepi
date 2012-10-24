# CodePen AwesomePI

An unofficial API for [CodePen](http://codepen.io) made by a fan.

This simple API parses the requested CodePen page with the [PHP Simple HTML DOM Parser](http://sourceforge.net/projects/simplehtmldom/)
and returns JSON.

2012 by http://timpietrusky.com


## Basics

### Base URL

    http://codepen-awesomepi.timpietrusky.com

### Response

The response is JSON-encoded (content-type: application/json).

If you want to use the response within JavaScript you can append `jsonp` as a callback.

### pentizr.js

Get your CodePens onto your website with [pentizr.js](https://github.com/TimPietrusky/pentizr).

```javascript
$(function() {
  $('.my-pens').pentizr({username: 'TimPietrusky'});
});
```

```html
<body>
  <div class="my-pens"></div>
</body>
```

#### JSONP example in jQuery

```javascript
$.ajax({
    dataType: 'jsonp',
    jsonp: 'jsonp',
    url: 'http://codepen-awesomepi.timpietrusky.com/picks',
    success: function (data) {
        alert(data);
    }
});
```


### Null values

If the value of a field is not specified, it will get the value `null`.

### Error handling

If the request is invalid you will get an error:

```javascript
{
    "status" : {
        "code":1337,
        "message":"invalid"
    },
    "content":null
};
```

### URL explanation

Why are there four URLs?

<table>
    <tr>
        <th>URL</th>
        <th>Description</th>
    </tr>
    
    <tr>
        <td>pen</td>
        <td>Code split view: Above is the source code (HTML, CSS, JS) and below is the CodePen</td>
    </tr>
    
    <tr>
        <td>details</td>
        <td>Details split view: Above are details, stats, lovers and comments and below is the CodePen</td>
    </tr>
    
    <tr>
        <td>full</td>
        <td>The CodePen is shown fullpage</td>
    </tr>
    
    <tr>
        <td>fullgrid</td>
        <td>The CodePen is shown fullpage, but all interactive stuff e.g. CSS3 animation or requestAnimationFrame is stopped after 5 seconds</td>
    </tr>
</table>


## API Reference

### /&lt;user&gt;

CodePens for a specific user. 

#### Method

    http://codepen-awesomepi.timpietrusky.com/{username}/{type}/{page}

#### Parameters

<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
        <th>Required</th>
    </tr>

    <tr>
    	<td>username</td>
    	<td>String</td>
    	<td>Name of the CodePen user</td>
    	<td>Yes</td>
    </tr>

    <tr>
        <td>type</td>
        <td>String</td>
        <td>
            <ul>
                <li>owned</li>
                <li>loved</li>
            </ul>
        </td>
        <td>Yes</td>
    </tr>

    <tr>
        <td>page</td>
        <td>Number</td>
        <td>The page to show</td>
        <td>No</td>
    </tr>
</table>



#### Example

Display page "1" of all "owned" pens of user "TimPietrusky"

    http://codepen-awesomepi.timpietrusky.com/TimPietrusky/owned/1

If you don't specify the page, it's automatically set to "1"

    http://codepen-awesomepi.timpietrusky.com/TimPietrusky/owned

```javascript
{
    "status": {
        "code":0,
        "message":"ok"
    },
    "content": {
        "pens": [
            {
                "title":"Breaking Bad",
                "description":"A tribute to the best fucking series in the world. ",
                "views":75218,
                "hearts":100,
                "comments":32,
                "url": {
                    "pen":"http:\/\/codepen.io\/TimPietrusky\/pen\/Bsegb",
                    "details":"http:\/\/codepen.io\/TimPietrusky\/details\/Bsegb",
                    "full":"http:\/\/codepen.io\/TimPietrusky\/full\/Bsegb",
                    "fullgrid":"http:\/\/codepen.io\/TimPietrusky\/fullgrid\/Bsegb"
                }
            }
        ]
    }
};

/* Note: Output was shortened. */
```

### /&lt;user&gt;/pen

A specific CodePen for a specific user. 

#### Method

    http://codepen-awesomepi.timpietrusky.com/{username}/pen/{hash}

#### Parameters

<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
        <th>Required</th>
    </tr>

    <tr>
        <td>username</td>
        <td>String</td>
        <td>Name of the CodePen user</td>
        <td>Yes</td>
    </tr>

    <tr>
        <td>pen</td>
        <td>String</td>
        <td>Get source (CSS, HTML, JavaScript) and tags</td>
        <td>Yes</td>
    </tr>

    <tr>
        <td>hash</td>
        <td>String</td>
        <td>The unique hash of the CodePen</td>
        <td>Yes</td>
    </tr>
</table>


#### Example

Get the source of the pen **WebPlatform.org logo** and the configuration stuff (e.g. prefix-free or SASS enabled). 

    http://codepen-awesomepi.timpietrusky.com/TimPietrusky/pen/fCejn

```javascript
{
   "status":{
      "code":0,
      "message":"ok"
   },
   "content":{
      "pen":{
         "created_at":"2012-10-08T21:59:25Z",
         "css":"@import url(http:\/\/fonts.googleapis.com\/css?family=Bitter:700);\n\n$background: #f7f4f0;\n\n$orange: rgba(247, 147, 17, 1);\n$red: rgba(221, 35, 15, .8);\n$purple: rgba(88, 56, 153, .65);\n$cyan: rgba(46, 179, 196, 1);\n\n$middle: #873E77;\n\nbody {\n  background:$background;\n  margin:0;\n}\n\nh1 {\n  position:absolute;\n  left:50%;\n  top:60%;\n  margin:0 0 0 -4em;\n  height:.5em;\n  width:.5em;\n  font:bold 2em\/2.5em 'Bitter', Georgia, serif;\n  letter-spacing:-.04em;\n  color:#474646;\n  border-radius:50%;\n  box-shadow:\n    \/* left - cross *\/\n    3.7em -2.4em 0 -.065em $background,\n    2.25em -.95em 0 -.065em $background,\n    3.7em -2.4em 0 .25em $middle,\n    2.25em -.95em 0 .25em $red,\n    \n    \/* left - vertical *\/\n    2.25em -3.55em 0 -.065em $background,\n    2.25em -3.55em 0 .25em $orange,\n    2.25em -.95em 0 .25em $orange,\n    \n    \/* right - cross *\/\n    5.155em -.95em 0 -.065em $background,\n    5.155em -.95em 0 .25em $purple,\n    \n    \/* right - vertical *\/\n    5.155em -3.55em 0 -.065em $background,\n    5.155em -3.55em 0 .25em $cyan,\n    5.155em -.95em 0 .25em $cyan\n  ;\n}\n\nh1:hover {\n  -webkit-filter:grayscale(.65);\n  filter:grayscale(.65);\n}\n\nh1:before,\nh1:after,\nh1 span:before,\nh1 span:after {\n  position:absolute;\n  content:'';\n  width:1em;\n}\n\n\/* left - vertical *\/\nh1:after {\n  z-index:-2;\n  height:2.55em;\n  top:-3.25em;\n  left:2em;\n  background:$orange;\n}\n\n\/* left - cross *\/\nh1:before {\n  z-index:-1;\n  height:2em;\n  top:-2.45em;\n  left:2.76em;\n  background:$red;\n  transform:rotate(45deg);\n}\n\nh1 span {\n  position:absolute;\n  left:6.475em;\n  top:0;\n  color:#a3a2a2;\n}\n\n\/* right - vertical *\/\nh1 span:after {\n  z-index:-2;\n  height:2.55em;\n  top:-3.25em;\n  left:-1.57em;\n  background:$cyan;\n}\n\n\/* right - cross *\/\nh1 span:before {\n  z-index:-1;\n  height:2em;\n  top:-2.45em;\n  left:-2.325em;\n  background:$purple;\n  transform:rotate(-45deg);\n}",
         "css_external":"",
         "css_pre_processor":"scss",
         "css_prefix_free":true,
         "css_starter":"neither",
         "description":"I want to celebrate the launch of the http:\/\/WebPlatform.org! A place to document the web for everybody. \n\nIt's the first version and it should definitely be improved & simplified.\n\nYou can see the single elements on ```h1:hover```\n\n## Web What?\nhttp:\/\/blog.webplatform.org\/2012\/10\/one-small-step",
         "head":"",
         "html":"<h1>WebPlatform<span>.org<\/span><\/h1>",
         "html_classes":"",
         "html_pre_processor":"none",
         "js":"\/**\n  WebPlatform.org logo\n  \n  # What? #\n  I want to celebrate the launch of the WebPlatform.org! \n  A place to document the web for everybody. \n\n\n  # 2012 by Tim Pietrusky\n  # timpietrusky.com\n**\/",
         "js_external":"",
         "js_library":"none",
         "js_modernizr":false,
         "js_pre_processor":"none",
         "private":null,
         "slug_hash":"fCejn",
         "title":"WebPlatform.org logo",
         "updated_at":"2012-10-10T06:59:08Z",
         "url":{
            "pen":"http:\/\/codepen.io\/pen\/fCejn",
            "details":"http:\/\/codepen.io\/details\/fCejn",
            "full":"http:\/\/codepen.io\/full\/fCejn",
            "fullgrid":"http:\/\/codepen.io\/fullgrid\/fCejn"
         }
      },
      "tags":[
         "css",
         "logo",
         "webplatform"
      ]
   }
}
```j

### /picks

Editor's Picks.

#### Method

    http://codepen-awesomepi.timpietrusky.com/picks/{page}

#### Parameters

<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
        <th>Required</th>
    </tr>

    <tr>
        <td>page</td>
        <td>Number</td>
        <td>The page to show</td>
        <td>No</td>
    </tr>
</table>

#### Example

Display page "2" of Editor's Picks

    http://codepen-awesomepi.timpietrusky.com/picks/2

```javascript
{
    "status": {
        "code":0,
        "message":"ok"
    },
    "content": {
        "pens": [
            {
                "title":"CSS Dribbble invite request",
                "description":"Pure CSS Dribbble logo. Pure CSS loader. Pure CSS animations. Pure CSS refle...",
                "views":320,
                "hearts":9,
                "comments":7,
                "url": {
                    "pen":"http:\/\/codepen.io\/HugoGiraudel\/pen\/FBbDd",
                    "details":"http:\/\/codepen.io\/HugoGiraudel\/details\/FBbDd",
                    "full":"http:\/\/codepen.io\/HugoGiraudel\/full\/FBbDd",
                    "fullgrid":"http:\/\/codepen.io\/HugoGiraudel\/fullgrid\/FBbDd"
                },
                "user": {
                    "nickname":"HugoGiraudel",
                    "realname":"Hugo Giraudel",
                    "gravatar":"https:\/\/secure.gravatar.com\/avatar\/729edf889ced7863dedba95452272bca?d=https:\/\/a248.e.akamai.net\/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png"
                }
            }
        ]
    }
};

/* Note: Output was shortened. */
```


### /popular

The most popular pens.

#### Method

    http://codepen-awesomepi.timpietrusky.com/popular/{page}

#### Parameters

<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
        <th>Required</th>
    </tr>

    <tr>
        <td>page</td>
        <td>Number</td>
        <td>The page to show</td>
        <td>No</td>
    </tr>
</table>

#### Example

```javascript
{
    "status": {
        "code":0,
        "message":"ok"
    },
    "content": {
        "pens": [
            {
                "title":"CSS3 iPhone v0.1",
                "description":"CSS3 iPhone v0.1 by Dylan Hudson (@dyln_hdsn on twitter)",
                "views":77500,
                "hearts":77,
                "comments":20,
                "url": {
                    "pen":"http:\/\/codepen.io\/dylnhdsn\/pen\/pheJs",
                    "details":"http:\/\/codepen.io\/dylnhdsn\/details\/pheJs",
                    "full":"http:\/\/codepen.io\/dylnhdsn\/full\/pheJs",
                    "fullgrid":"http:\/\/codepen.io\/dylnhdsn\/fullgrid\/pheJs"
                },
                "user": {
                    "nickname":"dylnhdsn",
                    "realname":"dylnhdsn",
                    "gravatar":"https:\/\/secure.gravatar.com\/avatar\/2e6377be71ded525989c6c101ddf133a?d=https:\/\/a248.e.akamai.net\/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png"
                }
            }
        ]
    }
};

/* Note: Output was shortened. */
```


### /recent

Recently added pens.

#### Method

    http://codepen-awesomepi.timpietrusky.com/recent/{page}

#### Parameters

<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
        <th>Required</th>
    </tr>

    <tr>
        <td>page</td>
        <td>Number</td>
        <td>The page to show</td>
        <td>No</td>
    </tr>
</table>

#### Example

```javascript
{
    "status": {
        "code":0,
        "message":"ok"
    },
    "content": {
        "pens": [
            {
                "title":null,
                "description":null,
                "views":1,
                "hearts":"",
                "comments":0,
                "url": {
                    "pen":"http:\/\/codepen.io\/chrisxclash\/pen\/mzoHt",
                    "details":"http:\/\/codepen.io\/chrisxclash\/details\/mzoHt",
                    "full":"http:\/\/codepen.io\/chrisxclash\/full\/mzoHt",
                    "fullgrid":"http:\/\/codepen.io\/chrisxclash\/fullgrid\/mzoHt"
                },
                "user": {
                    "nickname":"chrisxclash",
                    "realname":"chrisxclash",
                    "gravatar":"https:\/\/secure.gravatar.com\/avatar\/6d0056af25ebcda49d4e38c6985e6cb1?d=https:\/\/a248.e.akamai.net\/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png"
                }
            }
        ]
    }
};

/* Note: Output was shortened. */
```
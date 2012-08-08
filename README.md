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

A CodePen users owned or loved pens.

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
        <td>"owned" or "love"</td>
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
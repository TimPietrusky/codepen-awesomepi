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

    // Display page "1" of all "owned" pen's of user "TimPietrusky"
    http://codepen-awesomepi.timpietrusky.com/TimPietrusky/owned/1

    // If you don't specify the page, it's automatically set to "1"
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
                "title":"jasonx3000",
                "description":"visual vomit caused by stupid CSS trolling - or like I would say: jasonx3000...",
                "views":486,
                "hearts":2,
                "url": {
                    "pen":"http:\/\/codepen.io\/TimPietrusky\/pen\/jasonx3000\/2",
                    "fullgrid":"http:\/\/codepen.io\/TimPietrusky\/fullgrid\/jasonx3000\/2"}
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

    // Display page "2" of Editor's Picks
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
                "title":"CSS Button",
                "description":null,
                "views":387,
                "hearts":8,
                "url": {
                    "pen":"http:\/\/codepen.io\/bryanZavestoski\/pen\/7\/3",
                    "fullgrid":"http:\/\/codepen.io\/bryanZavestoski\/fullgrid\/7\/3"
                },
                "user": {
                    "nickname":"bryanZavestoski",
                    "realname":"Bryan Zavestoski",
                    "gravatar":"https:\/\/secure.gravatar.com\/avatar\/b50d4eef24b224d4e054346614c72832?d=https:\/\/a248.e.akamai.net\/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png"
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
                "url": {
                    "pen":"http:\/\/codepen.io\/dylnhdsn\/pen\/iphone\/23",
                    "fullgrid":"http:\/\/codepen.io\/dylnhdsn\/fullgrid\/iphone\/23"
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
                "url": {
                    "pen":"http:\/\/codepen.io\/chrisxclash\/pen\/4\/1",
                    "fullgrid":"http:\/\/codepen.io\/chrisxclash\/fullgrid\/4\/1"
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
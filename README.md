# CodePen AwesomePI

An unofficial API for [CodePen](http://codepen.io) made by a fan.

The API just parses the requested CodePen page with the [PHP Simple HTML DOM Parser](http://sourceforge.net/projects/simplehtmldom/)
and returns JSON-encoded objects (content-type: application/json).

2012 by http://timpietrusky.com


## API Reference

### Base URL

    http://codepen-awesomepi.timpietrusky.com

### Error handling

If the request is invalid you will get an error:

```javascript
{
    "status" : {
        "code":1337,
        "message":"invalid"
    },
    "content":null
}
```


### /&lt;user&gt;

A CodePen user.

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
}

### /picks

### /popular

### /recent


## Using the API
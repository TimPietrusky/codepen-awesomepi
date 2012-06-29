# CodePen AwesomePI

An unofficial API for [CodePen](http://codepen.io) made by a fan.

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

```javascript
    // Display page "1" of all "owned" pen's of user "TimPietrusky"
    http://codepen-awesomepi.timpietrusky.com/TimPietrusky/owned/1

    // If you don't specify the page, it's automatically set to "1"
    http://codepen-awesomepi.timpietrusky.com/TimPietrusky/owned
```


### /picks

### /popular

### /recent


## Using the API
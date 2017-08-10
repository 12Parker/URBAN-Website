function validate($siteIDError)
{
    var errors=[]; //Array for storing error messages
    //Check each required field
    var name = document.getElementById( "input-name" );
    if( name.value == "" || name.value == null )
    {
        console.log("Name Error");
        error = "Please Enter Your Name";
        errors.push(error);
    }

    var affiliation = document.getElementById( "input-affiliation" );
    if( affiliation.value == "" || affiliation.value == null )
    {
        console.log("Affiliation Error");
        error = "Please Enter Your Affiliation";
        errors.push(error);
    }

    var email = document.getElementById( "input-email" );
    if( email.value == "")
    {
        console.log("Email Error");
        error = "Please Enter A Valid Email Address";
        errors.push(error);
    }

    var timeExtracted = document.getElementById( "input-timeExtracted" );
    if( timeExtracted.value < 24 || timeExtracted.value > 120 )
    {
        console.log("Time Extracted Error");
        error = "The Extraction Time Should Be Between 24 and 120 Hours";
        errors.push(error);
    }

    var blueValue = document.getElementById( "input-blueValue" );
    if( blueValue.value < 20 || blueValue.value > 60  )
    {
        error = "Blue Value Should Be Between 20 and 60";
        errors.push(error);
    }

    var siteID = document.getElementById( "input-siteID" );
    var siteCheck = false;
    siteCheck = Number.isInteger(siteID);

    if(siteID.value.length < 5 || siteID.value.length > 5 || !(siteCheck))
    {
        console.log("SiteID Error");
        error = "Please Enter Your 5-digit Site ID";
        errors.push(error);
    } 
    if ($siteIDError == 'True') {
        console.log("SiteID Error");
        error = "Please Enter A Valid Site ID";
        errors.push(error);  
    }

    var siteDescription = document.getElementById( "input-siteDescription" );
    if( siteDescription.value == "" || siteDescription.value == null )
    {
        console.log("Site Description Error");
        error = "Please Enter A Site Description";
        errors.push(error);
    }

    var dateDeployed = document.getElementById( "input-dateDeployed" );
    if( dateDeployed.value == "" || dateDeployed.value == null  )
    {
        console.log("Date Deployed Error");
        error = "Date Deployed Is Required";
        errors.push(error);
    }

    var dateCollected = document.getElementById( "input-dateCollected" );
    if( dateCollected.value == "" || dateCollected.value == null )
    {
        console.log("Date Collected Error");
        error = "Date Collected Is Required";
        errors.push(error);
        //return false;
    } 
    else if (dateDeployed.value > dateCollected.value) 
    {
        console.log("Date Collected Error");
        error = "Date Collected Must Be Greater Than Date Deployed";
        errors.push(error); 
    }

    var rodLength = document.getElementById( "input-rodLength" );
    if( rodLength.value < 3 || rodLength.value > 10  )
    {
        error = "Rod Length Should Be Between 3 and 10cm";
        errors.push(error);
    }

    var lat = document.getElementById( "input-lat" );
    if( lat.value < -180 || lat.value > 180 )
    {
        error = "Latitude Must Be Between -180 and 180";
        errors.push(error);
    }

    var lng = document.getElementById( "input-lng" );
    if( lng.value < -180 || lng.value > 180  )
    {
        error = "Longitude Must Be Between -180 and 180";
        errors.push(error);
    }

    if (errors.length > 0) //If there are errors
    {
        
        var list = document.getElementById('errors');
        //Remove any previous errors
        while (list.hasChildNodes()) 
        {
            list.removeChild(list.lastChild);
        }

        console.log(errors);
        var ulist = document.createElement('ul');
        //Add all errors to a list and display them
        for (i = 0; i < errors.length; i++) 
        {
            var err = document.createElement('li');
            err.appendChild(document.createTextNode(errors[i]));
            var add = ulist.appendChild(err);
            list.appendChild(add);
        }
        //Scroll to top of page so user can see the errors
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        return false;
    } 
    else
    {
        return true;
    }
}


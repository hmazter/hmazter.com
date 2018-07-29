---
extends: _layouts.post
section: content

title: Testing Geocoding on Android
date: 2010-12-01 23:38
author: hmazter
category: Developing
tags: Android, Code Examples, Geocoding
slug: testing-geocoding-on-android
---

![TestGeocoding](/media/2010/12/TestGeocoding-200x300.png){.alignright}

Intro
-----

Recently I developed an application for Android that used reverse
geocoding, ie. get a human readable address from a latitude/longitude
position. To test what position i got for different location and to test
what addresses that translated to i developed this little neat
application.

Application info and download
-----------------------------

Application to test Positioning and Reverse geocoding (Address from
lat/lng). Optionally Save results to sdcard.

~~Download application (.apk)~~

~~Download source-code (.rar)~~

Explanation of code
-------------------

### Permissions

First off, we need to add the needed permissions to AndroidManifest.xml

``` {lang="xml"}
```

The permissions are for; accessing internet which is used by the
geocoder, using GPS and Network location, and writing files to SD-card.

### Get user location

Getting the location of the user is done with the
[LocationManager](http://developer.android.com/reference/android/location/LocationManager.html)
and
[LocationListener](http://developer.android.com/reference/android/location/LocationListener.html).
Start with getting in instance of the LocationManager.

```java
locationManager = (LocationManager)
        this.getSystemService(Context.LOCATION_SERVICE);
```

Then I start requesting location updates, we also supply which listener
that will handle location events.

```java
locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER,
        0, 0, locationListener);
locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER,
        0, 0, locationListener);
```

The listener i'm using is very simple and looks like this:

```java
LocationListener locationListener = new LocationListener() {
  public void onLocationChanged(Location location) {
    txt_lat.setText("" + location.getLatitude());
    txt_lng.setText("" + location.getLongitude());
  }
  public void onStatusChanged(String provider, int status, Bundle extras) {}
  public void onProviderEnabled(String provider) {}
  public void onProviderDisabled(String provider) {}
};
```

### Reverse geocoding

Now when we have a lat/lng position, either from a location update or
manually inputed in the text boxes, its time to do some reverse
geocoding. This is done with the
[Geocoder](http://developer.android.com/reference/android/location/Geocoder.html)
class, and looks like this:

```java
Geocoder myLocation = new Geocoder(getApplicationContext(), Locale.getDefault());
List<Address> geo_adresses = myLocation.getFromLocation(lat, lng, 1);
```

now check if there was a resulting address, in that case get it. And in
this application I wanted to see all different address fields that
returned.

```java
if(geo_adresses.size()>0){
  Address add = geo_adresses.get(0);
  for(int i = 0; i <= add.getMaxAddressLineIndex(); ++i){
    sb.append("AdressLine" + i + ": " + add.getAddressLine(i)+ "\n");
  }
  sb.append("AddminArea: "+ add.getAdminArea()+ "\n");
  sb.append("CoutryName: "+ add.getCountryName()+ "\n");
  sb.append("Premises: "+ add.getPremises()+ "\n");
  sb.append("SubAdminArea: "+ add.getSubAdminArea()+ "\n");
  sb.append("SubLocality: "+ add.getSubLocality()+ "\n");
  sb.append("Thoroughfare: "+ add.getThoroughfare()+ "\n");
  sb.append("SubThoroughfare: "+ add.getSubThoroughfare()+ "\n");

  txt_out.setText(sb.toString());
}
```

Conclusion
----------

I found this little application very handy to test situations that
don't occur during testing at home/office or with the emulator, to see
what values you can expect to get from users when the application is
live.

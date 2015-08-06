<?hh

namespace Entity;

enum ProviderType : int {
  Restaurant = 0;
  // TODO: Need to find a better type for this
  PumpitUpTypes = 1;
  Comedian = 2;
  Hotel = 3;
}

enum VenueAmenities : int {
  FullBar = 0;
  Rooftop = 1;
  Wifi = 2;
  Pool = 3;
  ValetParking = 4;
  StreetParking = 5;
  OutsideCatering = 6;
}

enum VenueFeatures : int {
  Party = 0;
  DinnerParty = 1;
  FilmingLocation = 2;
  PhotoShoot = 3;
  BirthdayParty = 4;
  OutsideFoodAllowed =
}

enum VenueType : string {
  Restaurant = 0;  
  BanquetHall = "Banquet Hall";
  Residential = "Residential";
  Gallery = "Gallery";
  Bar = 3;
  ConferenceCenter = 4;
  Loft = 5;
  Warehouse = 6;
}

enum Cuisines : string {
  "Asian" = "Asian";
}

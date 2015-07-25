<?hh

namespace Entity;

// TODO: There are multiple options here for this enum. Need to discuss with
// team.
// 1) Decalre it in ProviderNew since it is tied to Provider. This means that
// developers will have to include provider file to reference this type.
//
// 2) Create a sepatate Enum.cs and have all enums there.
//
// 3) Create a new file ProviderType.php. BAsically have a separate file for
// every enum.
enum ProviderType : int {
  Restaurant = 0;
  // TODO: Need to find a better type for this
  PumpitUpTypes = 1;
  Comedian = 2;
  Hotel = 3;
}

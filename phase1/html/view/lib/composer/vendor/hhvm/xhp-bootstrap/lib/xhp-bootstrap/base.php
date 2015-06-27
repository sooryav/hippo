<?hh
/*
 *  Copyright (c) 2014, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 *
 */

abstract class :bootstrap:base extends :x:element implements HasXHPHelpers {
  use XHPHelpers;

  attribute
    Stringish class,
    Stringish id;
}

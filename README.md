# Mainichi API
http://ws.mainichi-kotoba.com

Quick API that delivers a random japanese word daily, and its counterpart in english.

## /word
Delivers a single japanese word stored in cache with english definition counterpart. The first element in cache is poped out every day, and a new one is added.

**Method:**

`GET` | `POST`

**URL Params:**

*Optional:*

`?offset=[numeric]` chooses which word to get from the words stored in cache. If offset too large, loops back to the first word.

**Success Response:**

Code: `200` 
Content: ` { original: "博物館", originalReading: "はくぶつかん", translation: [ "museum" ], wordType: [ "Noun" ] } `

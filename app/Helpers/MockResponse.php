<?php

namespace App\Helpers;

class MockResponse
{
    public static function getNewsApiMockResponse(): array
    {
        return [
            "status" => true,
            "data" => [
                "status" => "ok",
                "totalResults" => 38,
                "articles" => [
                    [
                        "source" => [
                            "id" => null,
                            "name" => "Yahoo Entertainment"
                        ],
                        "author" => "Kari Anderson",
                        "title" => "LaNorris Sellers lifts No. 15 South Carolina over No. 12 Clemson for 17-14 win - Yahoo Sports",
                        "description" => "Sellers ran for both of the Gamecocks' touchdowns and led the team to a sixth straight win.",
                        "url" => "https://sports.yahoo.com/lanorris-sellers-lifts-no-15-south-carolina-over-no-12-clemson-for-17-14-win-203712933.html",
                        "urlToImage" => "https://s.yimg.com/ny/api/res/1.2/q6MhVLmY4FWPvoYf..zdZQ--/YXBwaWQ9aGlnaGxhbmRlcjt3PTEyMDA7aD04MDA-/https://s.yimg.com/os/creatr-uploaded-images/2024-11/28335e60-af59-11ef-9bfd-0f3120c808a7",
                        "publishedAt" => "2024-12-01T00:31:20Z",
                        "content" => "South Carolina quarterback LaNorris Sellers had a stellar game to lead the Gamecocks to a big win over Clemson. (AP Photo/Jacob Kupferman)\r\nNo. 12 Clemson's hopes of getting into the College Football… [+1851 chars]"
                    ],
                    [
                        "source" => [
                            "id" => "espn",
                            "name" => "ESPN"
                        ],
                        "author" => "ESPN staff",
                        "title" => "College football Rivalry Week live: What PSU win, Miami loss do to CFP field - ESPN",
                        "description" => "There's more than pride on the line for Rivalry Week. There are conference title stakes and playoff implications.",
                        "url" => "https://www.espn.com/college-football/story/_/id/42646010/college-football-rivalry-week-2024-live-ohio-state-michigan-notre-dame-usc-oregon",
                        "urlToImage" => "https://a1.espncdn.com/combiner/i?img=%2Fphoto%2F2024%2F1201%2Fr1421880_1296x729_16%2D9.jpg",
                        "publishedAt" => "2024-12-01T00:15:00Z",
                        "content" => "A week ago, six of the top 16 teams in the College Football Playoff rankings lost, shuffling conference title races and adding more teams to the bubble for the at-large bids.\r\nWeek 14 is Rivalry Week… [+246 chars]"
                    ],
                    [
                        "source" => [
                            "id" => null,
                            "name" => "Arizona Sports"
                        ],
                        "author" => null,
                        "title" => "ASU football routs Arizona, still awaiting help in Big 12 title chase - Arizona Sports",
                        "description" => "ASU routs Arizona in the 98th Territorial Cup on Saturday as the Sun Devils now wait and see if it did enough to reach the Big 12 Championship game.",
                        "url" => "https://arizonasports.com/story/3566182/asu-football-arizona-big-12/",
                        "urlToImage" => "https://arizonasports.com/wp-content/uploads/2024/11/Image-12.jpg",
                        "publishedAt" => "2024-11-30T23:56:57Z",
                        "content" => "Running back Cam Skattebo rushed for 177 yards and scored three touchdowns as No. 16 Arizona State routed Arizona for a 49-7 win in the 98th Territorial Cup on Saturday.\r\nWith the win, ASU will now w… [+1182 chars]"
                    ],
                    [
                        "source" => [
                            "id" => null,
                            "name" => "CBS Sports"
                        ],
                        "author" => "Cameron Salerno",
                        "title" => "Notre Dame vs. USC score: Live game updates, college football scores, NCAA top 25 highlights today - CBS Sports",
                        "description" => "Two interceptions returned the full length of the field were the key defensive plays for Notre Dame",
                        "url" => "https://www.cbssports.com/college-football/news/notre-dame-vs-usc-score-takeaways-pair-of-pick-sixes-lift-fighting-irish-effectively-punching-cfp-ticket/live/",
                        "urlToImage" => "https://sportshub.cbsistatic.com/i/r/2024/12/01/3851a044-2bfb-4774-bfdc-d39ba43fc8e6/thumbnail/1200x675/683adc5d2d6835573c1263cb32d7ff23/usc-nd-usatsi.jpg",
                        "publishedAt" => "2024-11-30T23:53:57Z",
                        "content" => "No. 5 Notre Dame defeated USC 49-35 on Saturday to put the program in prime position to reach the 12-team College Football Playoff next month. The Fighting Irish end the regular season with an 11-1 m… [+2291 chars]"
                    ]
                ]
            ]
        ];
    }
    public static function getTheGuardianMockResponse(): array
    {
        return [
            "status" => true,
            "data" => [
                "response" => [
                    "status" => "ok",
                    "userTier" => "developer",
                    "total" => 14,
                    "startIndex" => 1,
                    "pageSize" => 10,
                    "currentPage" => 1,
                    "pages" => 2,
                    "orderBy" => "newest",
                    "results" => [
                        [
                            "id" => "lifeandstyle/2024/dec/01/the-moment-i-knew-the-night-before-we-moved-in-together-we-saw-a-shooting-star-and-i-knew-wed-made-the-right-decision",
                            "type" => "article",
                            "sectionId" => "lifeandstyle",
                            "sectionName" => "Life and style",
                            "webPublicationDate" => "2024-11-30T19:00:37Z",
                            "webTitle" => "The moment I knew: the night before we moved in together, we saw a shooting star – and I knew we’d made the right decision",
                            "webUrl" => "https://www.theguardian.com/lifeandstyle/2024/dec/01/the-moment-i-knew-the-night-before-we-moved-in-together-we-saw-a-shooting-star-and-i-knew-wed-made-the-right-decision",
                            "apiUrl" => "https://content.guardianapis.com/lifeandstyle/2024/dec/01/the-moment-i-knew-the-night-before-we-moved-in-together-we-saw-a-shooting-star-and-i-knew-wed-made-the-right-decision",
                            "isHosted" => false,
                            "pillarId" => "pillar/lifestyle",
                            "pillarName" => "Lifestyle"
                        ],
                        [
                            "id" => "science/2024/dec/01/why-do-we-kiss-i-am-not-sure-we-have-anything-close-to-an-explanation",
                            "type" => "article",
                            "sectionId" => "science",
                            "sectionName" => "Science",
                            "webPublicationDate" => "2024-11-30T19:00:34Z",
                            "webTitle" => "Why do we kiss? ‘I am not sure we have anything close to an explanation’",
                            "webUrl" => "https://www.theguardian.com/science/2024/dec/01/why-do-we-kiss-i-am-not-sure-we-have-anything-close-to-an-explanation",
                            "apiUrl" => "https://content.guardianapis.com/science/2024/dec/01/why-do-we-kiss-i-am-not-sure-we-have-anything-close-to-an-explanation",
                            "isHosted" => false,
                            "pillarId" => "pillar/news",
                            "pillarName" => "News"
                        ],
                        [
                            "id" => "lifeandstyle/2024/nov/30/changing-the-subject-a-copenhagen-flatshare-gets-an-injection-of-colour",
                            "type" => "article",
                            "sectionId" => "lifeandstyle",
                            "sectionName" => "Life and style",
                            "webPublicationDate" => "2024-11-30T16:00:30Z",
                            "webTitle" => "Changing the subject: a Copenhagen flatshare gets an injection of colour",
                            "webUrl" => "https://www.theguardian.com/lifeandstyle/2024/nov/30/changing-the-subject-a-copenhagen-flatshare-gets-an-injection-of-colour",
                            "apiUrl" => "https://content.guardianapis.com/lifeandstyle/2024/nov/30/changing-the-subject-a-copenhagen-flatshare-gets-an-injection-of-colour",
                            "isHosted" => false,
                            "pillarId" => "pillar/lifestyle",
                            "pillarName" => "Lifestyle"
                        ],
                        [
                            "id" => "food/2024/nov/30/new-foodie-rules-waitrose-report",
                            "type" => "article",
                            "sectionId" => "food",
                            "sectionName" => "Food",
                            "webPublicationDate" => "2024-11-30T15:00:29Z",
                            "webTitle" => "The new foodie rules: bring me a bottle of olive oil, and for God’s sake don’t follow a recipe",
                            "webUrl" => "https://www.theguardian.com/food/2024/nov/30/new-foodie-rules-waitrose-report",
                            "apiUrl" => "https://content.guardianapis.com/food/2024/nov/30/new-foodie-rules-waitrose-report",
                            "isHosted" => false,
                            "pillarId" => "pillar/lifestyle",
                            "pillarName" => "Lifestyle"
                        ],
                        [
                            "id" => "society/2024/nov/30/evan-b-harris-portland-addiction-homelessness-america",
                            "type" => "article",
                            "sectionId" => "society",
                            "sectionName" => "Society",
                            "webPublicationDate" => "2024-11-30T13:00:26Z",
                            "webTitle" => "My friend was a popular, promising artist - how did he end up on the streets of Portland, addicted and dangerous?",
                            "webUrl" => "https://www.theguardian.com/society/2024/nov/30/evan-b-harris-portland-addiction-homelessness-america",
                            "apiUrl" => "https://content.guardianapis.com/society/2024/nov/30/evan-b-harris-portland-addiction-homelessness-america",
                            "isHosted" => false,
                            "pillarId" => "pillar/news",
                            "pillarName" => "News"
                        ]
                    ]
                ]
            ]
        ];
    }
    public static function getNewYorkTimesMockResponse(): array
    {
        return [
            "status" => true,
            "data" => [
                "status" => "OK",
                "copyright" => "Copyright (c) 2024 The New York Times Company. All Rights Reserved.",
                "section" => "U.S. News",
                "last_updated" => "2024-06-27T14:23:45-04:00",
                "num_results" => 25,
                "results" => [
                    [
                        "section" => "us",
                        "subsection" => "politics",
                        "title" => "Read Joe Biden’s Statement and His Grant of Clemency",
                        "abstract" => "President Biden issued the statement after signing a pardon for Hunter Biden Sunday night.",
                        "url" => "https://www.nytimes.com/2024/12/01/us/politics/biden-pardon-hunter-statement.html",
                        "uri" => "nyt://article/5bab0af7-8105-5ed6-af84-7b068306d977",
                        "byline" => "",
                        "item_type" => "Article",
                        "updated_date" => "2024-12-01T20:47:36-05:00",
                        "created_date" => "2024-12-01T20:08:28-05:00",
                        "published_date" => "2024-12-01T20:08:28-05:00",
                        "material_type_facet" => "",
                        "kicker" => "",
                        "des_facet" => [
                            "United States Politics and Government",
                            "Amnesties, Commutations and Pardons"
                        ],
                        "org_facet" => [],
                        "per_facet" => [
                            "Biden, Hunter",
                            "Biden, Joseph R Jr"
                        ],
                        "geo_facet" => [],
                        "multimedia" => null,
                        "short_url" => ""
                    ],
                    [
                        "section" => "us",
                        "subsection" => "politics",
                        "title" => "Kash Patel Would Bring Bravado and Baggage to F.B.I. Role",
                        "abstract" => "President-elect Donald J. Trump’s choice to run the F.B.I. has a record in and out of government that is likely to raise questions during his Senate confirmation hearings.",
                        "url" => "https://www.nytimes.com/2024/12/01/us/politics/kash-patel-bravado-baggage-fbi.html",
                        "uri" => "nyt://article/ec48a225-bc13-5001-b5de-6dae09d0633c",
                        "byline" => "By Glenn Thrush, Elizabeth Williamson and Adam Goldman",
                        "item_type" => "Article",
                        "updated_date" => "2024-12-01T19:01:21-05:00",
                        "created_date" => "2024-12-01T18:04:16-05:00",
                        "published_date" => "2024-12-01T18:04:16-05:00",
                        "material_type_facet" => "",
                        "kicker" => "",
                        "des_facet" => [
                            "United States Politics and Government",
                            "Presidential Election of 2024",
                            "Presidential Transition (US)",
                            "Appointments and Executive Changes",
                            "Presidential Election of 2020"
                        ],
                        "org_facet" => [
                            "Federal Bureau of Investigation",
                            "Justice Department"
                        ],
                        "per_facet" => [
                            "Patel, Kashyap",
                            "Trump, Donald J",
                            "Wray, Christopher A"
                        ],
                        "geo_facet" => [],
                        "multimedia" => [
                            [
                                "url" => "https://static01.nyt.com/images/2024/12/01/multimedia/01dc-patel-kwer/01dc-patel-kwer-superJumbo.jpg",
                                "format" => "Super Jumbo",
                                "height" => 1366,
                                "width" => 2048,
                                "type" => "image",
                                "subtype" => "photo",
                                "caption" => "The choice of Kash Patel amounted to a de facto dismissal of the current F.B.I. director, Christopher A. Wray, who was appointed to the job by Mr. Trump and still has almost three years left on his 10-year term.",
                                "copyright" => "Adriana Zehbrauskas for The New York Times"
                            ],
                            [
                                "url" => "https://static01.nyt.com/images/2024/12/01/multimedia/01dc-patel-kwer/01dc-patel-kwer-threeByTwoSmallAt2X.jpg",
                                "format" => "threeByTwoSmallAt2X",
                                "height" => 400,
                                "width" => 600,
                                "type" => "image",
                                "subtype" => "photo",
                                "caption" => "The choice of Kash Patel amounted to a de facto dismissal of the current F.B.I. director, Christopher A. Wray, who was appointed to the job by Mr. Trump and still has almost three years left on his 10-year term.",
                                "copyright" => "Adriana Zehbrauskas for The New York Times"
                            ],
                            [
                                "url" => "https://static01.nyt.com/images/2024/12/01/multimedia/01dc-patel-kwer/01dc-patel-kwer-thumbLarge.jpg",
                                "format" => "Large Thumbnail",
                                "height" => 150,
                                "width" => 150,
                                "type" => "image",
                                "subtype" => "photo",
                                "caption" => "The choice of Kash Patel amounted to a de facto dismissal of the current F.B.I. director, Christopher A. Wray, who was appointed to the job by Mr. Trump and still has almost three years left on his 10-year term.",
                                "copyright" => "Adriana Zehbrauskas for The New York Times"
                            ]
                        ],
                        "short_url" => ""
                    ]
                ]
            ]
        ];
    }
}
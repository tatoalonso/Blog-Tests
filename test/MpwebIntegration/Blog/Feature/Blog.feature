Feature: Post with persist & publish system
  In order to provide a functional Blog
  A user should be able to
  Save a post and/or publish it


  Background:
    Given a user with a valid <password> and a valid <email>


      | password  | email           |
      | Aev45679  | algo@gmail.com  |
      | 1234tyO5  | aslak@email.com |
      | pass1234  | bryan@email.org |

    And a valid post written with a valid <title> and a valid <body>

      | title  | body               |
      | title1 | a wonderful body   |
      | title2 | a great body       |
      | title3 | a standard body    |

    Scenario Outline:
      Given a post with <title> and <body>  which exists
      When  a user tries to create a post with the same <title> and <body>
      Then the post with can not be saved
      Examples:
        | title    | body   |
        | title1   | body1  |
        | title2   | body2  |
        | title3   | body3  |

      Scenario: New post saved but not publish it
        Given a post named "Random" with:
        """
        body
        ===============
        Here is the first paragraph of my blog post.
        Lorem ipsum dolor sit amet, consectetur adipiscing
        elit.

        """
        When a user wants save it
        But not publish it
        Then the post will be saved
        But the post will not be publish

        Scenario: New post saved and published
          Given  a another post named "Batman" with:
        """
        body2
        ===============
        The city never sleeps.

        """
          When a user wants save it
          And  publish it
          Then the post will be saved
          But the post will  be publish
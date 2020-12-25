Feature: Blog
  In order to publish content
  As a blog post author
  I need to be able to create, edit, show and delete posts
  As a blog reader
  I need to be able to create, show and delete comments

Scenario:
  Given I am on the homepage
  When I follow "Create a new post"
  And I fill in "title" with "My cool article"
  And I fill in "body" with "This is a cool story."
  And I fill in "tags" with "cool,swagg"
  And I fill in "author_name" with "Georges Abitbol"
  And I fill in "author_email" with "gabitbol@example.com"
  And I fill in "author_bio" with "L'homme le plus classe du monde, sérieusement !"
  And I press "Submit"
  Then the response status code should be 200
  And I should see "Post a comment"
  And I should see "My cool article"
  And I should see "This is a cool story"
  And I should see "cool"
  And I should see "swagg"
  And I should see "Georges Abitbol"
  And I should see "L'homme le plus classe du monde, sérieusement !"
  And the response should contain "gabitbol@example.com"

Scenario:
  Given I am on the homepage
  And I follow "My cool article"
  And I follow "Edit this post"
  And I fill in "title" with "My edited cool article"
  And I press "Submit"
  Then the response status code should be 200
  And I should see "My edited cool article"

Scenario:
  Given I am on the homepage
  When I follow "My edited cool article"
  And I fill in "author_name" with "Kévin"
  And I fill in "author_email" with "dunglas@gmail.com"
  And I fill in "body" with "My comment"
  And I press "Submit"
  Then the response status code should be 200
  And I should see "Kévin"
  And I should see "My comment"
  And the response should contain "dunglas@gmail.com"

Scenario:
  Given I am on the homepage
  When I follow "My edited cool article"
  And I follow "Delete this post"
  Then the response status code should be 200
  And I should not see "My cool article"
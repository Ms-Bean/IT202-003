# Project Name: Simple Shop
## Project Summary: A shop that allows users to register accounts and buy decorative and edible cacti
## Github Link: https://github.com/Spencer-Clarke/IT202-003/tree/prod
## Project Board Link: https://github.com/Spencer-Clarke/IT202-003/projects/1
## Website Link: https://sdc2-prod.herokuapp.com/Project/login.php
## Your Name: Spencer Clarke 

<!--
### Line item / Feature template (use this for each bullet point)
#### Don't delete this

- [ ] \(mm/dd/yyyy of completion) Feature Title (from the proposal bullet point, if it's a sub-point indent it properly)
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
### End Line item / Feature Template
--> 
### Proposal Checklist and Evidence
- Each item contains issue associated with it, as well as the pull request which contains the screenshots
- Milestone 1

     - [x] User will be able to register a new account
      - https://github.com/Spencer-Clarke/IT202-003/issues/28
        - Form Fields
            - Username, email, password, confirm password (other fields optional)
              - Registration form screenshot
                ![image](https://user-images.githubusercontent.com/89927037/141153303-25550e62-4467-4c4f-adaa-fa5d9d86af94.png)
            - Email is required and must be validated
              - Email validation and sanitization
               ![image](https://user-images.githubusercontent.com/89927037/141153371-db016d33-0a31-4ef3-bec7-2e1e9fc362c4.png)
            - Username is required
              - See registration form screenshot
            - Confirm password’s match
              - Message after entering mismatching passwords
              ![image](https://user-images.githubusercontent.com/89927037/141153502-78df94bf-a95d-4e14-ae6c-388c367ef677.png)
            - Users Table
                - Id, username, email, password (60 characters), created, modified
            - Password must be hashed (plain text passwords will lose points)
              - Users table containing hashed passwords
              ![image](https://user-images.githubusercontent.com/89927037/141153631-a9625b67-2932-45eb-bc02-9377606ae7a8.png)
            - Email should be unique
              - Message after entering duplicate email
                ![image](https://user-images.githubusercontent.com/89927037/141153847-39fbb506-9327-4744-884c-0e988cc042ae.png)
            - Username should be unique
              - Message after entering duplicate username
               ![image](https://user-images.githubusercontent.com/89927037/141153904-d759f7c2-bb07-4718-b80e-0436ac6936fb.png)
            - System should let user know if username or email is taken and allow the user to correct the error without wiping/clearing the form
            - The only fields that may be cleared are the password fields
              - Fields containing persisted data after entering taken email
               ![image](https://user-images.githubusercontent.com/89927037/141154030-a8e6ca82-7d44-4bcd-be3b-feb5bbb474a9.png)
    - [ ] User will be able to login to their account (given they enter the correct credentials)
      -https://github.com/Spencer-Clarke/IT202-003/issues/29
        - Form
            - User can login with email or username
                -This can be done as a single field or as two separate fields
                  - Everything is complete except for this. I could not figure out how to determine whether the input was a username or an invalidly typed email
            -Password is required
              - Login page screenshot
              ![image](https://user-images.githubusercontent.com/89927037/141154350-14d0087c-46a7-4f34-87bd-97b5afcfabc8.png)
        - User should see friendly error messages when an account either doesn’t exist or if passwords don’t match
          - User friendly error message after entering bad input
          ![image](https://user-images.githubusercontent.com/89927037/141154439-1a77f251-f8d3-437c-a387-39cb9d8e08e1.png)
        - Logging in should fetch the user’s details (and roles) and save them into the session.
          - Data fetch and addition to session
          ![image](https://user-images.githubusercontent.com/89927037/141154528-93a0ad63-845f-4229-b93f-a771e8f5eb09.png)
        - User will be directed to a landing page upon login
            - This is a protected page (non-logged in users shouldn’t have access)
            - This can be home, profile, a dashboard, etc         
              - Home page upon logging in screenshot
              ![image](https://user-images.githubusercontent.com/89927037/141154713-357598ad-6f20-4d30-9e3b-0289ace5052c.png)
              - Protection against users who arent loggred in
              ![image](https://user-images.githubusercontent.com/89927037/141154821-2bae8739-0b17-487c-ad49-ea72e58c3057.png)
    - [x] User will be able to logout
      -https://github.com/Spencer-Clarke/IT202-003/issues/30
      -https://github.com/Spencer-Clarke/IT202-003/pull/27
        - Logging out will redirect to login page
        - User should see a message that they’ve successfully logged out
          - Logout page with message that user logged out
          ![image](https://user-images.githubusercontent.com/89927037/141154956-929cb579-b480-400d-a887-73f1c956c504.png)
        - Session should be destroyed (so the back button doesn’t allow them access back in)
          - Session destruction code
          ![image](https://user-images.githubusercontent.com/89927037/141155157-9ff32fad-6325-4deb-aab4-db8f05ecc3a2.png)
    - [x] Basic security rules implemented
      -https://github.com/Spencer-Clarke/IT202-003/issues/31
      -https://github.com/Spencer-Clarke/IT202-003/pull/27
        - Authentication:
            - Function to check if user is logged in
            - Function should be called on appropriate pages that only allow logged in users
             - is_logged_in function
             ![image](https://user-images.githubusercontent.com/89927037/141155586-77bc05c1-a4df-4617-bd35-af4ae8b42a99.png)

        - Roles/Authorization:
            - Have a roles table (see below)
    - [x] Basic Roles implemented
      -https://github.com/Spencer-Clarke/IT202-003/issues/36
        - Have a Roles table    (id, name, description, is_active, modified, created)
          - Roles table
          ![image](https://user-images.githubusercontent.com/89927037/141155984-df8c694d-8d8a-4014-a3c6-8132168a45df.png)
        - Have a User Roles table (id, user_id, role_id, is_active, created, modified
          - User roles table
          ![image](https://user-images.githubusercontent.com/89927037/141156056-1e4cbaca-cfcd-49bf-9131-819868981970.png)
        - Include a function to check if a user has a specific role (we won’t use it for this milestone but it should be usable in the future)
          - has_role function
          ![image](https://user-images.githubusercontent.com/89927037/141156122-60bb5f4c-112d-412d-8128-4b42f951dc85.png)

    - [x] Site should have basic styles/theme applied; everything should be styled
      -https://github.com/Spencer-Clarke/IT202-003/issues/32
        - I.e., forms/input, navigation bar, etc
          - Minty green login page with things in css-defined boxes
           ![image](https://user-images.githubusercontent.com/89927037/141156300-c37f6219-f373-43a3-8d7e-f65244d42766.png)
    - [x] Any output messages/errors should be “user friendly”
      -https://github.com/Spencer-Clarke/IT202-003/issues/33
        - Any technical errors or debug output displayed will result in a loss of points
          - Rounding off of remaining non-user friendly errors
          ![image](https://user-images.githubusercontent.com/89927037/141156474-e330242f-a1e0-4b0b-bf49-be72f5678539.png)
    - [x] User will be able to see their profile
      -https://github.com/Spencer-Clarke/IT202-003/issues/34
        - Email, username, etc
          - Profile page visible, successful password reset
          ![image](https://user-images.githubusercontent.com/89927037/141156716-85c02d50-18cd-4704-af6f-c4be2466fd12.png)

    - [x] User will be able to edit their profile
      -https://github.com/Spencer-Clarke/IT202-003/issues/35
        - Changing username/email should properly check to see if it’s available before allowing the change
          - Duplicate username caught
          ![image](https://user-images.githubusercontent.com/89927037/141156895-b405cb3d-f511-474d-b511-341cf8997c73.png)
        - Any other fields should be properly validated
        - Allow password reset (only if the existing correct password is provided)
            - Hint: logic for the password check would be similar to login
              - Invalid password message on profile page
              ![image](https://user-images.githubusercontent.com/89927037/141157242-9cf80035-ad52-4e5e-ac09-f41dc9580216.png)

- Milestone 2
    - [ ] User with an admin role or shop owner role will be able to add products to inventory
      - Table should be called Products (id, name, description, category, stock, created, modified, unit_price, visibility [true, false])
    - [ ] Any user will be able to see products with visibility = true on the Shop page
      - Product list page will be public (i.e. doesn’t require login)
      - For now limit results to 10 most recent
      - User will be able to filter results by category
      - User will be able to filter results by partial matches on the name
      - User will be able to sort results by price
  - [ ] Admin/Shop owner will be able to see products with any visibility
    - This should be a separate page from Shop, but will be similar
    - This page should only be accessible to the appropriate role(s)
  - [ ] Admin/Shop owner will be able to edit any product
    - Edit button should be accessible for the appropriate role(s) anywhere a product is shown (Shop list, Product Details Page, etc)
  - User will be able to click an item from a list and view a full page with more info about the item (Product Details Page)
  - [ ] User must be logged in for any Cart related activity below
  - [ ] User will be able to add items to Cart
    - Cart will be table-based (id, product_id, user_id, desired_quantity, unit_cost, created, modified)
    - Adding items to Cart will not affect the Product's quantity in the Products table
  - [ ] User will be able to see their cart
    - List all the items
    - Show subtotal for each line item based on desired_quantity * unit_cost
    - Show total cart value (sum of line item subtotals)
    - Will be able to click an item to see more details (Product Details Page)
  - [ ] User will be able to change quantity of items in their cart
    - Quantity of 0 should also remove from cart
  - [ ] User will be able to remove a single item from their cart vai button click
  - [ ] User will be able to clear their entire cart via a button click

- Milestone 3
- Milestone 4
### Intructions
#### Don't delete this
1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
  1. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
  2. Add, commit, push the related file changes to this branch
  3. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
     - Screenshot(s) of the site view (make sure they clearly show the feature)
     - Screenshot of the database data if applicable
     - Describe each screenshot to specify exactly what's being shown
     - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
  4. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)
    - Basically add an x to the checkbox markdown along with a date after
      - (i.e.,   - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel
  5. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)
    - Merge the Milestone branch into dev, then dev into prod as needed
    - Last two steps are mostly for getting it to prod for delivery of the assignment 
  7. If the attached issues don't close wait until the next step
  8. Merge the updated dev branch into your production branch via a pull request
  9. Close any related issues that didn't auto close
    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board
- Milestone 3
- Milestone 4
### Intructions
#### Don't delete this
1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
  1. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
  2. Add, commit, push the related file changes to this branch
  3. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
     - Screenshot(s) of the site view (make sure they clearly show the feature)
     - Screenshot of the database data if applicable
     - Describe each screenshot to specify exactly what's being shown
     - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
  4. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)
    - Basically add an x to the checkbox markdown along with a date after
      - (i.e.,   - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel
  5. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)
    - Merge the Milestone branch into dev, then dev into prod as needed
    - Last two steps are mostly for getting it to prod for delivery of the assignment 
  7. If the attached issues don't close wait until the next step
  8. Merge the updated dev branch into your production branch via a pull request
  9. Close any related issues that didn't auto close
    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board

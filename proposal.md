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
<table><tr><td>milestone 2</td></tr><tr><td><table><tr><td>F1 - User with an admin role or shop owner role will be able to add products to inventory (11/22/2021)</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/admin/add_item.php](https://sdc2-prod.herokuapp.com/Project/admin/add_item.php)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/82](https://github.com/Spencer-Clarke/IT202-003/pull/82)</p></td></tr><tr><td><table><tr><td>F1 - Table should be called Products<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143949593-79b5886a-0076-43e3-895a-1764987064f7.png"><p>New item form</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143949772-ed849527-c1bb-424f-a8fb-e119542bfbba.png"><p>Products table</td></tr></td></tr></table></td></tr><table><tr><td>F2 - Any user will be able to see products with visibility = true (11/28/2021)</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/shop.php](https://sdc2-prod.herokuapp.com/Project/shop.php)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/85](https://github.com/Spencer-Clarke/IT202-003/pull/85)</p><p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/96](https://github.com/Spencer-Clarke/IT202-003/pull/96)</p></td></tr><tr><td><table><tr><td>F2 - Product list page will be public (doesn't require login)<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143950858-01928ecd-8d7f-4cb8-aa87-52445c7b2ed1.png"><p>Image of absence of login check on shop page</td></tr></td></tr></table></td></tr><tr><td><table><tr><td>F2 - User will be able to search by category and partial string match on name<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143950353-3f772041-640a-44bc-8b95-5a4b590c6d89.png"><p>Partial string and category search</td></tr></td></tr></table></td></tr><tr><td><table><tr><td>F2 - For now limit results to 10 most recent<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143951995-2f76083c-6626-4b8b-822a-2e3594b72239.png"><p>Limiter passed into sql string</td></tr></td></tr></table></td></tr><tr><td><table><tr><td>F2 - User will be able to sort by price<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143950520-441620be-ec30-49bd-a411-b120669d13c1.png"><p>Items sorted by price</td></tr></td></tr></table></td></tr><table><tr><td>F3 - Admin/Shop Owner will be able to see products with any visibility (11/24/2021)</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/admin/list_items.php](https://sdc2-prod.herokuapp.com/Project/admin/list_items.php)</p></td></tr><tr><td>PRs:<p>

 [https://sdc2-prod.herokuapp.com/Project/admin/list_items.php](https://github.com/Spencer-Clarke/IT202-003/pull/83)</p></td></tr><tr><td><table><tr><td>F3 - This page should be separate from shop, but similar<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143952420-408059c3-7542-446a-80fd-ba92998e531a.png"><p>All items listed on list items page</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143952594-6d15ea88-d620-40fa-9a6f-981a6433ae99.png"><p>San pedro cactus, with visibility=false, listed on list items page but not on shop page</td></tr></td></tr></table></td></tr><tr><td><table><tr><td>F3 - Page should only be accessible by admn<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143953253-f6a8364f-e9ac-450f-9390-7ba815856d70.png"><p>Admin role check</td></tr></td></tr></table></td></tr><table><tr><td>F4 - Admin will be able to edit any product (11/27/2021)</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/admin/edit_item.php?id=1](https://sdc2-prod.herokuapp.com/Project/admin/edit_item.php?id=1)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/84](https://github.com/Spencer-Clarke/IT202-003/pull/84)</p></td></tr><tr><td><table><tr><td>F4 - Edit button will be accessible anywhere a product is shown for users with correct roles<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143953750-594c1de6-829f-48f7-9802-df7e59ce2425.png"><p>Edit page</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143953826-40b40a55-8763-40ad-b723-b8912f0c0525.png"><p>Edit links echoed when user has admin role</td></tr></td></tr></table></td></tr><table><tr><td>F5 - User will be able to click an item from a list and get more info (11/28/2021)</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/item_info.php?id=1](https://sdc2-prod.herokuapp.com/Project/item_info.php?id=1)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/86](https://github.com/Spencer-Clarke/IT202-003/pull/86)</p></td></tr><tr><td><table><tr><td>F5 - Info page<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143954271-228dd42c-a343-403e-9341-07ca360f67ea.png"><p>Information page for succulent, visited by clicking link seen alongside edit button in shop</td></tr></td></tr></table></td></tr><table><tr><td>F6 - User must be logged in for any cart related activity</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/add_to_cart.php?id=3](https://sdc2-prod.herokuapp.com/Project/add_to_cart.php?id=3)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/87](https://github.com/Spencer-Clarke/IT202-003/pull/87)</p></td></tr><tr><td><table><tr><td>F6 - User must be logged in for cart related activity<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143954641-022899ac-064b-4020-b428-3de1a2a878eb.png"><p>Die if user is not logged in</td></tr></td></tr></table></td></tr><table><tr><td>F7 - User will be able to add items to cart</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/add_to_cart.php?id=3](https://sdc2-prod.herokuapp.com/Project/add_to_cart.php?id=3)</p></td></tr><tr><td>PRs:<p>

 [https://sdc2-prod.herokuapp.com/Project/add_to_cart.php?id=3](https://sdc2-prod.herokuapp.com/Project/add_to_cart.php?id=3)</p></td></tr><tr><td><table><tr><td>F7 - Cart will be table based (id, product_id, user_id, desired_quantity, unit_cost, date-created, date-modified)<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143954915-bffba0b1-4999-4ae4-98af-01f53b6f9a02.png"><p>Cart database</td></tr></td></tr></table></td></tr><tr><td><table><tr><td>F7 - Adding items to cart will not affect products table<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143956232-1d8da3fe-b430-41fa-a446-09e8fcf91d07.png"><p>Add to cart page which doesn't do anything to the products table</td></tr></td></tr></table></td></tr><table><tr><td>F8 - User will be able to see their cart</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/cart.php](https://sdc2-prod.herokuapp.com/Project/cart.php)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/88](https://github.com/Spencer-Clarke/IT202-003/pull/88)</p></td></tr><tr><td><table><tr><td>F8 - List all the items, show sub total, show cart total, link to product info (all four shown in same image)<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143956535-a6c42bdb-dfb3-406d-831f-70ceb65f68cc.png"><p>Item list, sub total, cart total, link to product info</td></tr></td></tr></table></td></tr><table><tr><td>F9 - User will be able to change quantity of items in cart (11/28/2021)</td></tr><tr><td>Links:<p>

 [https://user-images.githubusercontent.com/89927037/143956535-a6c42bdb-dfb3-406d-831f-70ceb65f68cc.png](https://user-images.githubusercontent.com/89927037/143956535-a6c42bdb-dfb3-406d-831f-70ceb65f68cc.png)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/89](https://github.com/Spencer-Clarke/IT202-003/pull/89)</p><p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/90](https://github.com/Spencer-Clarke/IT202-003/pull/90)</p></td></tr><tr><td><table><tr><td>F9 - Quantity of 0 should also remove from cart<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143957074-519fe28f-e2ad-476a-95e4-355bb995ee97.png"><p>Saguaro cactus quantity changed from 17 to 13, subtotal and grand total changed themselves accordingly</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143957342-416eb8d9-9ee9-42fe-9b9f-4f5a7549b8c8.png"><p>Deletion if quantity is set to 0</td></tr></td></tr></table></td></tr><table><tr><td>F10 - User will be able to remove a single cart item via button click (11/29/2021)</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/cart.php](https://sdc2-prod.herokuapp.com/Project/cart.php)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/91](https://github.com/Spencer-Clarke/IT202-003/pull/91)</p><p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/92](https://github.com/Spencer-Clarke/IT202-003/pull/92)</p></td></tr><tr><td><table><tr><td>F10 - User will be able to remove item via button click<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143957729-5dc2080f-dc81-4686-80f4-382cd98b4406.png"><p>Cart after succulent removed by remove button</td></tr></td></tr></table></td></tr><table><tr><td>F11 - User will be able to clear their entire cart via button click (11/29/2021)</td></tr><tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/cart.php](https://sdc2-prod.herokuapp.com/Project/cart.php)</p></td></tr><tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/91](https://github.com/Spencer-Clarke/IT202-003/pull/91)</p><p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/92](https://github.com/Spencer-Clarke/IT202-003/pull/92)</p></td></tr><tr><td><table><tr><td>F11 - User will be able to clear entire cart via button click (11/29/2021)<tr><td>Status: completed</td></tr><tr><td><img width="100%" src="https://user-images.githubusercontent.com/89927037/143958034-1b260968-18d0-4a53-8e61-b8d567c8e22f.png"><p>Cart after saguaro cactus removed via empty cart button (empty)</td></tr></td></tr></table></td></tr></td></tr></table>

<table>
<tr><td>milestone 3</td></tr><tr><td>
<table>
<tr><td>F1 - User will be able to purchase items in their cart (2021-12-09)</td></tr>
<tr><td>Status: complete</td></tr>
<tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/checkout.php](https://sdc2-prod.herokuapp.com/Project/checkout.php)</p></td></tr>
<tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/109](https://github.com/Spencer-Clarke/IT202-003/pull/109)</p><p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/113](https://github.com/Spencer-Clarke/IT202-003/pull/113)</p><p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/116](https://github.com/Spencer-Clarke/IT202-003/pull/116)</p></td></tr>
<tr><td>
<table>
<tr><td>F1 - Create an Orders Table</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145649282-1d661806-94dd-43c7-9791-2510ca405dee.png">
<p>Orders Table</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table>
<tr><td>F1 - Create an OrderItems table</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145646285-388e2864-e2a9-4fc6-89c3-b5a74ad4abd3.png">
<p>OrderItems table</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table>
<tr><td>F1 - Checkout form</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145646621-f58d4de0-b0c1-4d94-8418-e2c451afe5ed.png">
<p>Checkout form, with proper html value types</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table>
<tr><td>F1 - User should be asked for their address for shipping purposes</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145651345-7ea39508-344b-47e3-a22b-40ac8152f514.png">
<p>Address Validation from form, can also be seen in orders table</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table>
<tr><td>F1 - Order Process</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145646812-d869c907-fca2-47bd-8d24-3ccad0116b02.png">
<p>Array operations used to determine if any item in cart exceeds its counterpart in Products table, or if the user has insufficient funds</p>
</td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145650321-b0a63e71-e799-4069-ad05-0bb94e693104.png">
<p>Update products and cart table with new information</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<table>
<tr><td>F2 - Order Confirmation page (2021-12-09)</td></tr>
<tr><td>Status: complete</td></tr>
<tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/order_confirmation.php?id=9](https://sdc2-prod.herokuapp.com/Project/order_confirmation.php?id=9)</p></td></tr>
<tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/111](https://github.com/Spencer-Clarke/IT202-003/pull/111)</p></td></tr>
<tr><td>
<table>
<tr><td>F2 - Show the entire order details from Orders and OrderItems tables</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145651697-1bf978f9-4006-4189-b1a0-f099b198c3af.png">
<p>Order confirmation page for Order 9</p>
</td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145652047-fb5094a9-c4ac-492e-ba57-63e1a92647eb.png">
<p>Checks if order id is associated with user trying to access page, redirects to home.php otherwise</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table>
<tr><td>F2 - Displays a thank you message</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145651697-1bf978f9-4006-4189-b1a0-f099b198c3af.png">
<p>It says "Thank you"</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<table>
<tr><td>F3 - User will be able to see their purchase history (2021-12-09)</td></tr>
<tr><td>Status: complete</td></tr>
<tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/purchase_history.php](https://sdc2-prod.herokuapp.com/Project/purchase_history.php)</p></td></tr>
<tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/112](https://github.com/Spencer-Clarke/IT202-003/pull/112)</p></td></tr>
<tr><td>
<table>
<tr><td>F3 - For now limit to 10 most recent</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145652332-4b8e01f6-a1b7-4abe-9675-a4a69fe4b606.png">
<p>purchase history page</p>
</td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145652413-68004d45-62b6-479c-b234-7d9491b23665.png">
<p>Limit to 10</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table>
<tr><td>F3 - A list item can be clicked to view order details</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145652486-be73c034-802c-42bc-a333-4b54de4e09f3.png">
<p>Order details page with no thank you message</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<table>
<tr><td>F4 - Store Owner will be able to see all purchase history (2021-12-09)</td></tr>
<tr><td>Status: complete</td></tr>
<tr><td>Links:<p>

 [https://sdc2-prod.herokuapp.com/Project/purchase_history.php](https://sdc2-prod.herokuapp.com/Project/purchase_history.php)</p></td></tr>
<tr><td>PRs:<p>

 [https://github.com/Spencer-Clarke/IT202-003/pull/112](https://github.com/Spencer-Clarke/IT202-003/pull/112)</p></td></tr>
<tr><td>
<table>
<tr><td>F4 - For now limit to 10 most recent orders</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145652629-a56c9eb0-ebb9-4908-8db8-c759671963aa.png">
<p>Role created for store owner</p>
</td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145652770-6b829ae3-894f-45e8-9ecd-bd50962ce43b.png">
<p>Owner can see everyone's past orders on purchase_history.php</p>
</td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145653395-bb631d70-c01d-46b2-a42b-88fef3ce1657.png">
<p>Order placed by user 19 available to user 6 (owner) in purchase_history.php</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table>
<tr><td>F4 - A list item can be clicked to view order details</td></tr>
<tr><td>Status: 
<img width="100" height="20" src="https://via.placeholder.com/400x120/009955/fff?text=completed"></td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145652978-86167242-d50c-4e3b-a86e-d631f8a5945f.png">
<p>order_details.php redirects users if the order id is not associated with the user, but it makes an exception for the owner, allowing them to view the details of any order</p>
</td></tr>

<tr><td>
<img width="768px" src="https://user-images.githubusercontent.com/89927037/145653493-76ea448c-d8b5-4336-a41a-f1c7f9833636.png">
<p>Order details from user 19 available to user 6</p>
</td></tr>

</td>
</tr>
</table>
</td>
</tr></td></tr></table>

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


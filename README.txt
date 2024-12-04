1. Navigate to the directory with loggedin.html
2. Run "python -m http.server 8000" in the console.
    - This page is used as a Callback URL to link AWS Cognito to the EC2. Cognito Callback
     requires HTTPS and HTTPS would not work in our EC2 without purchasing a domain or having
     certain licensing. The only way to use HTTP is to use local host, so we used this page as
     a middleman between the two.
3. Use the following EC2 Endpoint: http://ec2-50-19-129-214.compute-1.amazonaws.com
4. Navigate to the Cognito Sign In/Sign Up
5. Navigate to the main page of the website
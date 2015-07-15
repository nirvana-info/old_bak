package com.zecco.mobile.test;

import java.util.ArrayList;

import junit.framework.Assert;

import com.zecco.mobile.R;
import com.zecco.mobile.activity.login.Login;
//import com.zecco.mobile.activity.maintabs.*;
//import com.jayway.android.robotium.solo.Solo;
import android.test.suitebuilder.annotation.Smoke;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

public class Signin extends TestBase {
	


	public Signin() {
		super("com.zecco.mobile.activity.common", Login.class);

	}
	public String UN = "venturaprice";
	
    public String PW = "Passw0rd";

    @Smoke
    public void test01_SignIn_correct() throws Throwable{
    	this.UserSignIn(UN, PW); 
        solo.assertCurrentActivity("LoginFailed", "MainTabActivity");
    } 
    
    @Smoke
    public void test02_SignIn_IncorrectUN() throws Throwable{
        this.UserSignIn("incorrect", PW);
        assertTrue(this.solo.searchText("Oops! Your username or password was incorrect. Please try again."));    
    }

    @Smoke
    public void test03_SignIn_IncorrectPW() throws Throwable{
        this.UserSignIn(UN, "incorrect");
        assertTrue(this.solo.searchText("Oops! Your username or password was incorrect. Please try again."));    
    }
    
    @Smoke
    public void test04_SignIn_NoUN() throws Throwable{
    	UserSignIn("",PW);
        assertTrue(this.solo.searchText("Please enter your username")); 
    }
    
    @Smoke
    public void test05_SignIn_NoPW() throws Throwable{
    	 UserSignIn(UN, "");
         assertTrue(this.solo.searchText("Please enter your password"));        
    }
   
    @Smoke 	
    public void test06_SignIn_SkipSignIn() throws Throwable{
       solo.clickOnText("Skip Sign In");
       solo.sleep(800);
       solo.assertCurrentActivity("LoginFailed", "MainTabActivity");
   }
    
    @Smoke
    public void test07_SignIn_BoxKeepMeSignin() throws Throwable{
       	solo.clickOnCheckBox(0);
     	assertTrue(this.solo.searchText("By enabling the"));
     			
   }
    
    @Smoke
     public void test20_SignIn_KeepMeSigninIni() throws Throwable{
    	solo.clearEditText(0);
      	solo.clearEditText(1);
      	solo.enterText(0, UN);
      	solo.enterText(1, PW);
      	solo.clickOnCheckBox(0);
      	solo.clickOnButton(0);
  		solo.clickOnButton(0);
//  		solo.waitForActivity("MainTabActivity");
  		solo.sleep(20000);
  		solo.waitForDialogToClose(400000);
//  	solo.goBack();
//    	solo.clickOnText("Skip Sign In");
//  	solo.sleep(10000);
//  	solo.goBackToActivity("MainTabActivity");
 		solo.clickOnView(solo.getView(R.id.img_settings));
 		solo.clickOnText("Sign Out");
 		solo.waitForActivity("Login");
    }
 		




    @Smoke
    public void test09_SignIn_FromPorfolios() throws Throwable{
   	    solo.clickOnText("Skip Sign In");
   	    solo.waitForDialogToClose(40000);
   	    solo.goBack();
   	    solo.clickOnView(solo.getView(R.id.img_portfolios));
   	    solo.clickOnButton("Sign In to Your Zecco Account");
   	    UserSignIn();
        solo.sleep(2000);
        boolean s = solo.waitForActivity("TabPortfoliosActivity", 4000);
      if(s)
      {
        solo.assertCurrentActivity("Fail to catch the porfolios page", "TabPortfoliosActivity");	
      }
    }
    


    
    @Smoke
    public void test10_SignIn_FromTrade() throws Throwable{
   	    solo.clickOnText("Skip Sign In");
   	    solo.waitForDialogToClose(40000);
   	    solo.goBack();
   	    solo.clickOnView(solo.getView(R.id.img_trades));
   	    solo.clickOnButton("Sign In to Your Zecco Account");
   	    UserSignIn();
        solo.sleep(2000);
        boolean s = solo.waitForActivity("TabTradesActivity", 4000);
        if(s)
        {
        solo.assertCurrentActivity("Fail to catch the Trade page", "TabTradesActivity");	
        }

}

    
    @Smoke
    public void test11_SignIn_FromAlerts() throws Throwable{
    	 solo.clickOnText("Skip Sign In");
    	 solo.waitForDialogToClose(40000);
    	 solo.goBack();
    	 solo.clickOnView(solo.getView(R.id.img_alerts));
	    solo.clickOnButton("Sign In to Your Zecco Account");
	    UserSignIn();
	    solo.sleep(2000);
	    boolean s = solo.waitForActivity("TabAlertsActivity", 4000);
	    if(s)
	    {
	    	solo.assertCurrentActivity("Fail to catch the Trade page", "TabAlertsActivity");	
	    }
   }
    
    
//    public void UserSignIn() throws InterruptedException
//    {
//    @Override
//    public  void tearDown() throws Exception {
//		try {
//			solo.finalize();
//		} catch (Throwable e) {
//			e.printStackTrace();
//		}
//		getActivity().finish();
//		super.tearDown();
//	}
//    }

}
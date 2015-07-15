package com.zecco.mobile.test;

import java.util.ArrayList;

import junit.framework.Assert;

import com.zecco.mobile.R;
import com.zecco.mobile.activity.login.Login;
import com.zecco.mobile.activity.portfolios.*;

import android.test.suitebuilder.annotation.Smoke;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;


public class Portfolios extends TestBase {
	


	public Portfolios() {
		super("com.zecco.mobile.activity.common", Login.class);
	}
	String _PorfoliosAccount = "Individual - ****6771"; 
	String _TotalAccountEquity = null;
	int _line = 0;
	TextView _SymbolPortfolios = null;
	TextView _QtyPortfolios = null;
	TextView _LastPricePortfolios = null;
	TextView _DayChgPortfolios = null;
	TextView _DayGainPortfoios = null;
	TextView _SymbolComPortfolios = null;
	TextView _PerDayChgPortfolios = null;
	String _SPortfolios = null;
	String _QPortfolios = null;
	String _LPPortfolios = null;
	String _DCPortfolios = null;
	String _DGPortfolios = null;
	String _SCPortfolios = null;
	String _PDCPortfolios = null;
	@Smoke
	    public void test01_PorfoliosStock() throws Throwable{
		  UserSignIn();

		  TextView P_Account = (TextView)solo.getView(R.id.text_account_individual_portfolios);
		  
		  if (P_Account.toString().equals(_PorfoliosAccount))
		  {
			  solo.clickOnView(P_Account);
//			 LinearLayout ParentPortfoliosListView = (LinearLayout)(P_Account.getParent().getParent().getParent());
		  }
		  else
		  {
			  assertTrue(false);
		  }
		
				 
		  ArrayList<ListView> lv = solo.getCurrentListViews();
			for (_line = 0; _line < lv.get(2).getChildCount(); _line++)
			{

				LinearLayout ll = (LinearLayout)lv.get(2).getChildAt(_line);
				LinearLayout xx = (LinearLayout)ll.getChildAt(0);
				LinearLayout xxx = (LinearLayout)xx.getChildAt(1);
			    LinearLayout xxxx0 = (LinearLayout)xxx.getChildAt(0);
			    LinearLayout xxxx1 = (LinearLayout)xxx.getChildAt(1);
			    
				_SymbolPortfolios = (TextView)xxxx0.getChildAt(0);
				_QtyPortfolios = (TextView)xxxx0.getChildAt(1);
				_LastPricePortfolios = (TextView)xxxx0.getChildAt(2);
				_DayChgPortfolios = (TextView)xxxx0.getChildAt(3);
				_DayGainPortfoios = (TextView)xxxx0.getChildAt(4);
				_SymbolComPortfolios =  (TextView)xxxx1.getChildAt(0);
				_PerDayChgPortfolios =  (TextView)xxxx1.getChildAt(2);
				
				if (_SymbolPortfolios.getText().toString().equals("A"))
				{
					_SPortfolios = (String)_SymbolPortfolios.getText();
					_LPPortfolios = (String)_QtyPortfolios.getText();
					_LPPortfolios = (String)_LastPricePortfolios.getText();
					_DCPortfolios = (String)_DayChgPortfolios.getText();
					_DGPortfolios = (String)_DayGainPortfoios.getText();
					_SCPortfolios = (String)_SymbolComPortfolios.getText();
					_PDCPortfolios = (String)_PerDayChgPortfolios.getText();
					break;
				}
			}
			if (_SymbolPortfolios == null)
			{
				assertTrue(false);
			}
           solo.clickOnView(_SymbolPortfolios);
           solo.waitForDialogToClose(40000);
	  }

	  
//	  @Smoke
//	    public void test02_PortfoliosMF() throws Throwable{
//		  
//		  UserSignIn();
//	  }
//
//	  @Smoke
//	    public void test03_PortfoliosMF() throws Throwable{
//		  UserSignIn();
//	  }
//	  
//	  @Smoke
//	    public void test04_PortfoliosETFs() throws Throwable{
//		  UserSignIn();
//	  }
//	  
//	  @Smoke
//	    public void test05_PortfoliosNoAccount() throws Throwable{
//		  UserSignIn();
//	  }


//	    } 
//	  
//	  @Smoke
//	  public void test03 throws Throwable{
//		  sdf
//	  }
//	  
//	  @Smoke
//	  public void test04_ throws Throwable{
//		  
//	  }
//	  
//	  @Smoke
//	  public void test05 throws Throwable{
//		  
//	  }
	  
//	  private void UserSignIn(String un, String pd) throws InterruptedException
//	    {
//	    	solo.clearEditText(0);
//	    	solo.clearEditText(1);
//	    	
//	    	solo.enterText(0, un);
//	    	solo.enterText(1, pd);
//	        
//			solo.clickOnButton(0);
//			
//			solo.sleep(8000);
//	    }
	}
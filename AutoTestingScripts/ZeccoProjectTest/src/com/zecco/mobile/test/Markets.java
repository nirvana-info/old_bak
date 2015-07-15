package com.zecco.mobile.test;

import java.util.ArrayList;

import org.w3c.dom.Text;
import kankan.wheel.widget.*;
import kankan.wheel.widget.adapters.ArrayWheelAdapter;
import kankan.wheel.widget.adapters.WheelViewAdapter;
import junit.framework.Assert;

import com.zecco.mobile.R;
//import com.zecco.mobile.activity.common.*;
import com.zecco.mobile.activity.login.Login;
import com.zecco.mobile.activity.portfolios.*;
import com.zecco.mobile.usercontrol.tab.NavTabBar;
import com.zecco.mobile.usercontrol.tab.NavTabMenuItem;
import com.zecco.mobile.usercontrol.tab.enums.NavTabBarMenuEnum;

import android.app.Activity;
import android.app.Instrumentation.ActivityMonitor;
import android.os.IBinder;
import android.test.suitebuilder.annotation.Smoke;
import android.text.Layout;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class Markets extends TestBase {
	
	private static final View LinearLayout = null;

	public Markets() {
		super("com.zecco.mobile.activity.common", Login.class);
	}
boolean _isLPMatch;
boolean _isTCMatch;
boolean _isVMatch;
boolean _isNewsMatch;
int _line = 0;
int Markets_criteria_line = 0;
int _MarketNewsCount = 0;
String _LPMarkets = null;
String _SMarkets = null;
String _VMarkets = null;
String _TCMarkets = null;
String _LPQuoteProfile = null;
String _TCQuoteProfile = null;
String _VQuoteProfile = null;
TextView _TodaysChangeMarkets = null;
TextView _SymbolMarkets = null;
TextView _LastPriceMarkets = null;
TextView _LastPriceQuoteProfile = null;
TextView _TodaysChangeQuotesProfile = null;
TextView _VolumeMarkets = null;
TextView _VolumeQuoteProfile = null;
	
// Indices tab	
	@Smoke
    public void test0001_MarketIndexDelayNotice() throws Throwable{
	 
	 solo.clickOnText("Skip Sign In");
	 solo.sleep(20);
   	 solo.goBack();
   	 solo.clickOnText("Indices delay notice");
   	 boolean _isTC1= solo.searchText("Indices Delay Notice");
   	 boolean _isTC2 = solo.searchText("minutes");
   	 assertEquals("Indices Delay title cannot be found", true, _isTC1); 
   	 assertEquals("Indices Delay description cannot be found", true, _isTC2); 
   	  	}
	
	@Smoke
	public void test0002_MarketIndexTabCount() throws Throwable{
		this.ToMarkets();
//		solo.clickOnView(solo.getView(R.id.tab_markets_markets));
//		TextView _LastPriceMarkets = (TextView)solo.getView(R.id.text_last_recentquotes);
//		String _LPMarkets= _LastPriceMarkets.getText().toString();
		ArrayList<ListView> lv = solo.getCurrentListViews();
		
		for (_line = 0; _line < lv.get(0).getChildCount(); _line++)
		{
			ArrayList<String> al = new ArrayList<String>();
			al.add("NASDAQ");
			al.add("NYSE");
			al.add("AMEX");
			
			LinearLayout ll = (LinearLayout)lv.get(0).getChildAt(_line);
			_SymbolMarkets = (TextView)ll.getChildAt(0);
			_LastPriceMarkets = (TextView)ll.getChildAt(1);
			_TodaysChangeMarkets = (TextView)ll.getChildAt(2);
			
			if (al.contains(_SymbolMarkets.getText().toString()))
			{
				_SMarkets = (String)_SymbolMarkets.getText();
				_LPMarkets = (String)_LastPriceMarkets.getText();
				_TCMarkets = (String)_TodaysChangeMarkets.getText();
				break;
			}
		}
		if (_SymbolMarkets == null)
		{
			assertTrue(false);
		}
		
        solo.clickOnText("NASDAQ|NYSE|AMEX");
		solo.sleep(10);
//		solo.isTextChecked("Loading Quote Data");
		solo.waitForDialogToClose(40000);
		
		CheckTab("Index");
		 
		_LastPriceQuoteProfile = (TextView)solo.getView(R.id.text_lastprice_market_position_quote);
		_LPQuoteProfile = _LastPriceQuoteProfile.getText().toString();
		_TodaysChangeQuotesProfile = (TextView)solo.getView(R.id.text_lastprice_market_position_quote);
		_TCQuoteProfile = _TodaysChangeQuotesProfile.getText().toString();
		
		if ( _LPQuoteProfile.equals(_LPMarkets) )	
	    	{
		    	_isLPMatch = true ;
	    	}
		else
			{
				_isLPMatch = false ;
			}
		boolean  expected_LPMatch = true;
		boolean actual_LPMatch = _isLPMatch;
		assertEquals("Last price is unmatched.", expected_LPMatch, actual_LPMatch); 
				
		if ( _TCQuoteProfile.equals(_TCMarkets) )				
	    {
		    _isTCMatch = true ;
		}
		else
		{
			_isTCMatch = false ;
		}
		boolean  expected_TCMatch = true;
		boolean actual_TCMatch = _isLPMatch;
		assertEquals("Today's Change is unmatched.", expected_TCMatch, actual_TCMatch); 		
	}

	@Smoke
	public void test0003_MarketIndexOtherTabCount() throws Throwable{
		this.ToMarkets();
		ArrayList<ListView> lv = solo.getCurrentListViews();
		
		for (_line = 0; _line < lv.get(0).getChildCount(); _line++)
		{
			ArrayList<String> al = new ArrayList<String>();
			al.add("DJIA");
			al.add("Nikkei 225");
			al.add("Hang seng");
			
			LinearLayout ll = (LinearLayout)lv.get(0).getChildAt(_line);
			_SymbolMarkets = (TextView)ll.getChildAt(0);
			_LastPriceMarkets = (TextView)ll.getChildAt(1);
			_TodaysChangeMarkets = (TextView)ll.getChildAt(2);
			
			if (al.contains(_SymbolMarkets.getText().toString()))
			{
				_SMarkets = (String)_SymbolMarkets.getText();
				_LPMarkets = (String)_LastPriceMarkets.getText();
				_TCMarkets = (String)_TodaysChangeMarkets.getText();
				break;
			}
		}
		if (_SymbolMarkets == null)
		{
			assertTrue(false);
		}
		
        solo.clickOnText("DJIA|Nikkei 225|Hang seng");
		solo.sleep(10);
		solo.isTextChecked("Loading Quote Data");
		solo.waitForDialogToClose(60000);
		
		//Showed tab
		CheckTab("IndexOther");
		
		_LastPriceQuoteProfile = (TextView)solo.getView(R.id.text_lastprice_market_position_quote);
		_LPQuoteProfile = _LastPriceQuoteProfile.getText().toString();
		_TodaysChangeQuotesProfile = (TextView)solo.getView(R.id.text_lastprice_market_position_quote);
		_TCQuoteProfile = _TodaysChangeQuotesProfile.getText().toString();
		
		if ( _LPQuoteProfile.equals(_LPMarkets) )	
	    	{
		    	_isLPMatch = true ;
	    	}
		else
			{
				_isLPMatch = false ;
			}
		boolean  expected_LPMatch = true;
		boolean actual_LPMatch = _isLPMatch;
		assertEquals("Last price is unmatched.", expected_LPMatch, actual_LPMatch); 
				
		if ( _TCQuoteProfile.equals(_TCMarkets) )				
	    {
		    _isTCMatch = true ;
		}
		else
		{
			_isTCMatch = false ;
		}
		boolean  expected_TCMatch = true;
		boolean actual_TCMatch = _isLPMatch;
		assertEquals("Today's Change is unmatched.", expected_TCMatch, actual_TCMatch); 		
	}

	@Smoke
	public void test0004_MarketIndexRefresh() throws Throwable{
		solo.clickOnText("Skip Sign In");
        solo.goBack();
		solo.clickOnView(solo.getView(R.id.btn_refresh_market_position_quote));
		boolean isDateShow=solo.isTextChecked("(ET)");
		assertEquals("Fail to refresh.", false, isDateShow); 
	}

	@Smoke
	public void test0005_MarketIndexloading() throws Throwable{
		solo.clickOnText("Skip Sign In");
		solo.sleep(1);
		boolean trueText = solo.isTextChecked("Loading Indices");
		boolean falseText = solo.isTextChecked("Loading Indices.");
		assertEquals("Loading Indices words cannot be found.", false, trueText & falseText);
	}
	
	@Smoke
	public void test0006_MarketIndexLabel() throws Throwable{
	   this.ToMarkets();
	   LinearLayout a = (LinearLayout)((LinearLayout)solo.getView(R.id.marketmovers_tabview_market_position_quote)).getChildAt(0);
	   String Label0 = ((TextView)a.getChildAt(0)).getText().toString();
	   String Label1 = ((TextView)a.getChildAt(1)).getText().toString();
	   String Label2 = ((TextView)a.getChildAt(2)).getText().toString();
	   assertEquals("Label[Index] display incorrect.", "Index", Label0); 
	   assertEquals("Label[Last] display incorrect.", "Last", Label1); 
	   assertEquals("Label[Today's Change] display incorrect.", "Today's Change", Label2); 
	}
	
	@Smoke
	public void test0007_MarketIndexDateCheck() throws Throwable{
		solo.clickOnText("Skip Sign In");
		solo.goBack();
		boolean Date = solo.searchText("(ET)");
		assertEquals("Date shows correct", true, Date);
//		Date.indexOf("(ET)")>=0
	}
	
	@Smoke
	public void test0008_MarketIndexNumColor() throws Throwable{
		
	}
	
	@Smoke
	public void test0009_MarketIndexNumDecimal() throws Throwable{
		
	}
	
	//	MarketMovers tab
	@Smoke
	public void test0101_MarketStockTabCount() throws Throwable{
		this.ToMarkets();
		solo.clickOnText("Market Mover");
		solo.sleep(20);
		solo.isTextChecked("Loading Market Movers");
		solo.waitForDialogToClose(40000);
//		TextView _LastPriceMarkets = (TextView)solo.getView(R.id.text_last_recentquotes);
//		String _LPMarkets= _LastPriceMarkets.getText().toString();
		ArrayList<ListView> lv = solo.getCurrentListViews();
		
		
		for (_line = 0; _line < lv.get(1).getChildCount(); _line++)
		{
			ArrayList<String> al = new ArrayList<String>();
			al.add("AAPL");
			al.add("BAC");
			al.add("IBM");

			
			LinearLayout ll = (LinearLayout)lv.get(1).getChildAt(_line);
			_SymbolMarkets = (TextView)ll.getChildAt(0);
			_LastPriceMarkets = (TextView)ll.getChildAt(1);
			_VolumeMarkets= (TextView)ll.getChildAt(2);
			_TodaysChangeMarkets = (TextView)ll.getChildAt(3);
			
			
			if (al.contains(_SymbolMarkets.getText().toString()))
			{
				_SMarkets = (String)_SymbolMarkets.getText();
				_LPMarkets = "$".concat((String)_LastPriceMarkets.getText());
				_VMarkets = (String)_VolumeMarkets.getText();
				_TCMarkets = (String)_TodaysChangeMarkets.getText();
				
				break;
			}
		}
		if (_SymbolMarkets == null)
		{
			assertTrue(false);
		}
		
        solo.clickOnText("AAPL|BAC|IBM");
		solo.sleep(10);
		solo.isTextChecked("Loading Quote Data");
		solo.waitForDialogToClose(60000);
		
		//Showed tab
		CheckTab("Stock");
		
		_LastPriceQuoteProfile = (TextView)solo.getView(R.id.text_lastprice_market_position_quote);
		_LPQuoteProfile = _LastPriceQuoteProfile.getText().toString();
		_TodaysChangeQuotesProfile = (TextView)solo.getView(R.id.text_todaychange_market_position_quote);
		_TCQuoteProfile = _TodaysChangeQuotesProfile.getText().toString();
		_VolumeQuoteProfile = (TextView)solo.getView(R.id.text_volume_market_position_quote);
		_VQuoteProfile = _VolumeQuoteProfile.getText().toString();
		
		if ( _LPQuoteProfile.equals(_LPMarkets) )	
	    	{
		    	_isLPMatch = true ;
	    	}
		else
			{
				_isLPMatch = false ;
			}
		boolean  expected_LPMatch = true;
		boolean actual_LPMatch = _isLPMatch;
		assertEquals("Last price is unmatched.", expected_LPMatch, actual_LPMatch); 
				
		if ( _TCQuoteProfile.equals(_TCMarkets) )				
	    {
		    _isTCMatch = true ;
		}
		else
		{
			_isTCMatch = false ;
		}
		boolean  expected_TCMatch = true;
		boolean actual_TCMatch = _isLPMatch;
		assertEquals("Today's Change is unmatched.", expected_TCMatch, actual_TCMatch); 
		
		if ( _VQuoteProfile.equals(_VMarkets) )				
	    {
		    _isVMatch = true ;
		}
		else
		{
			_isVMatch = false ;
		}
		boolean  expected_VMatch = true;
		boolean actual_VMatch = _isLPMatch;
		assertEquals("Volume is unmatched.", expected_VMatch, actual_VMatch); 
	}

	@Smoke
	public void test0102_ModalPopupCreate() throws Throwable{
//		this.ToMarkets();
//		solo.clickOnText("Market Mover");
//		solo.sleep(20);
//		solo.isTextChecked("Loading Market Movers");
//		solo.waitForDialogToClose(40000);
//		TextView _LastPriceMarkets = (TextView)solo.getView(R.id.text_last_recentquotes);
//		String _LPMarkets= _LastPriceMarkets.getText().toString();
//		ArrayList<ListView> lv = solo.getCurrentListViews();
//		
//		
//		for (_line = 0; _line < lv.get(1).getChildCount(); _line++)
//		{
//			ArrayList<String> al = new ArrayList<String>();
//			al.add("VIG");
//			al.add("QQQ");
//			al.add("FXI");
//			al.add("FXP");
//			al.add("SQQQ");
//
//			
//			LinearLayout ll = (LinearLayout)lv.get(1).getChildAt(_line);
//			_SymbolMarkets = (TextView)ll.getChildAt(0);
//			_LastPriceMarkets = (TextView)ll.getChildAt(1);
//			_VolumeMarkets= (TextView)ll.getChildAt(2);
//			_TodaysChangeMarkets = (TextView)ll.getChildAt(3);
//			
//			
//			if (al.contains(_SymbolMarkets.getText().toString()))
//			{
//				_SMarkets = (String)_SymbolMarkets.getText();
//				_LPMarkets = "$".concat((String)_LastPriceMarkets.getText());
//				_VMarkets = (String)_VolumeMarkets.getText();
//				_TCMarkets = (String)_TodaysChangeMarkets.getText();
//				
//				break;
//			}
//			else
//			{
//
//				solo.clickOnView(solo.getView(R.id.text_criteria_marketmovers_markets));
//				WheelView wview_markets = (WheelView)solo.getView(R.id.wheel_markets);
//				ArrayWheelAdapter<String> adapter_markets = (ArrayWheelAdapter<String>)wview_markets.getViewAdapter();
//				WheelView wview_marketmovers = (WheelView)solo.getView(R.id.wheel_marketmovers_criteria);
//				ArrayWheelAdapter<String> adapter_marketmovers = (ArrayWheelAdapter<String>)wview_marketmovers.getViewAdapter();
//		        //adapter_markets.getItemText(2);
//				
//				wview_marketmovers.setCurrentItem(2);
//				adapter_marketmovers.getItemText(2);
//				solo.scrollUpList(2);
//				
//				solo.clickOnView(solo.getView(R.id.btn_done));
//				solo.waitForDialogToClose(4000);
//				solo.sleep(60000);
//	
//	
//				for (Markets_criteria_line = 0; ;Markets_criteria_line ++)
//				{
//					
//				}
//				
//			}
//		}
//		if (_SymbolMarkets == null)
//		{
//			assertTrue(false);
//		}
//		
//        solo.clickOnText("VIG|QQQ|FXI|FXP|SQQQ");
//		solo.sleep(10);
//		solo.isTextChecked("Loading Quote Data");
//		solo.waitForDialogToClose(60000);
//		
//		//Showed tab
//		CheckTab("ETFs"); 
//		 
//		_LastPriceQuoteProfile = (TextView)solo.getView(R.id.text_lastprice_market_position_quote);
//		_LPQuoteProfile = _LastPriceQuoteProfile.getText().toString();
//		_TodaysChangeQuotesProfile = (TextView)solo.getView(R.id.text_todaychange_market_position_quote);
//		_TCQuoteProfile = _TodaysChangeQuotesProfile.getText().toString();
//		_VolumeQuoteProfile = (TextView)solo.getView(R.id.text_volume_market_position_quote);
//		_VQuoteProfile = _VolumeQuoteProfile.getText().toString();
//		
//		if ( _LPQuoteProfile.equals(_LPMarkets) )	
//	    	{
//		    	_isLPMatch = true ;
//	    	}
//		else
//			{
//				_isLPMatch = false ;
//			}
//		boolean  expected_LPMatch = true;
//		boolean actual_LPMatch = _isLPMatch;
//		assertEquals("Last price is unmatched.", expected_LPMatch, actual_LPMatch); 
//				
//		if ( _TCQuoteProfile.equals(_TCMarkets) )				
//	    {
//		    _isTCMatch = true ;
//		}
//		else
//		{
//			_isTCMatch = false ;
//		}
//		boolean  expected_TCMatch = true;
//		boolean actual_TCMatch = _isLPMatch;
//		assertEquals("Today's Change is unmatched.", expected_TCMatch, actual_TCMatch); 
//		
//		if ( _VQuoteProfile.equals(_VMarkets) )				
//	    {
//		    _isVMatch = true ;
//		}
//		else
//		{
//			_isVMatch = false ;
//		}
//		boolean  expected_VMatch = true;
//		boolean actual_VMatch = _isLPMatch;
//		assertEquals("Volume is unmatched.", expected_VMatch, actual_VMatch); 
	}
	
	@Smoke
	public void test0103_MarketMoverLoading() throws Throwable{
        this.ToMarkets();
        solo.clickOnText("Market Mover");
        solo.sleep(1);
		boolean trueText = solo.isTextChecked("Loading Market Movers");
		boolean falseText = solo.isTextChecked("Loading Market Movers.");
		assertEquals("Loading Market Movers words cannot be found.", false, trueText & falseText);
	}
	
	@Smoke
	public void test0104_MarketMoverTextChange() throws Throwable{
	
	}
	
	@Smoke
	public void test0105_MarketMoverLabel() throws Throwable{
		this.ToMarkets();
		solo.clickOnText("Market Mover");
		solo.waitForDialogToClose(6000);
		solo.goBack();
		LinearLayout l1 = (LinearLayout)solo.getView(R.id.layout_title_marketmovers_tabview);
		TextView Symbol = (TextView)l1.getChildAt(0);
		TextView Last = (TextView)l1.getChildAt(1);
		TextView Volume = (TextView)l1.getChildAt(2);
		TextView TChange = (TextView)l1.getChildAt(3);
		assertEquals("Labels has been hidden.", true, l1.isShown());
		assertEquals("Label[Symbol] display incorrect.", "Symbol", Symbol.getText().toString());
		assertEquals("Label[Last] display incorrect.", "Last", Last.getText().toString());
		assertEquals("Label[Volume] display incorrect.", "Volume", Volume.getText().toString());
		assertEquals("Label[Today's Change] display incorrect.", "Today's Change", TChange.getText().toString());
		
	}
	
	@Smoke
	public void test0106_ModelPopupCancel() throws Throwable{
		
	}

	@Smoke
	public void test0107_MarketMoverRefresh() throws Throwable{
		this.ToMarkets();
		solo.clickOnText("Market Mover");
		solo.waitForDialogToClose(6000);
		solo.goBack();
		TextView refresh = (TextView)solo.getView(R.id.btn_refresh_market_position_quote);
		solo.clickOnView(refresh);
		assertEquals("Fail to refresh.", false, refresh.isShown()); 
	}
	
	@Smoke
	public void test0108_MarketMoverDateCheck() throws Throwable{
	    this.ToMarkets();
	    solo.clickOnText("Market Mover");
        solo.waitForDialogToClose(6000);
        solo.goBack();
        TextView refresh = (TextView)solo.getView(R.id.btn_refresh_market_position_quote);
		assertEquals("Date shows correct", true, refresh.getText().toString().indexOf("(ET)")>=0);

	}
	
	@Smoke
	public void test0109_MarketMoverNumColor() throws Throwable{
		
	}
	
	@Smoke
	public void test0110_MarketMoverNumDecimal() throws Throwable{
		
	}
	
	
//	MarketNews tab
	@Smoke
	public void test0201_MarketNews() throws Throwable{
		this.ToMarkets();
		solo.clickOnText("Market News");
		solo.waitForDialogToClose(4000);
		ArrayList<ListView> lv = solo.getCurrentListViews();
		_MarketNewsCount = lv.get(2).getChildCount();
		TextView MarketNewsSymbol = (TextView)solo.getView(R.id.text_newstitle_list_news);
		String _NewsSymbol = MarketNewsSymbol.getText().toString();
		solo.clickOnView(MarketNewsSymbol);
		solo.waitForDialogToClose(60000);
        TextView NewsTitle = (TextView)solo.getView(R.id.text_newstitle);
        String _NewsTitle = NewsTitle.getText().toString();
        	if (_NewsSymbol.equals(_NewsTitle))
        	{
        		_isNewsMatch = true;
        	}
        	else
        	{
        		_isNewsMatch = false;
        	}
        
        boolean  expected_NewsMatch = true;
		boolean  actual_NewsMatch = _isNewsMatch;
		assertEquals("News title is unmatched.", expected_NewsMatch, actual_NewsMatch); 
		

	}
	
	@Smoke
	public void test0202_MarketNewsLoading() throws Throwable{
		this.ToMarkets();
		solo.clickOnText("Market News");
		solo.sleep(1);
		boolean trueText = solo.isTextChecked("Loading Market News");
		boolean falseText = solo.isTextChecked("Loading Market News.");
		assertEquals("Loading Indices words cannot be found.", false, trueText & falseText);
	}
	
	@Smoke
	public void test0203_MarketNewsRefresh() throws Throwable{
		this.ToMarkets();
		solo.clickOnText("Market News");
		solo.waitForDialogToClose(6000);
		solo.goBack();
		TextView refresh = (TextView)solo.getView(R.id.btn_refresh_market_position_quote);
		assertEquals("Fail to refresh.", true, refresh.isShown()); 
		solo.clickOnView(refresh);
		assertEquals("Fail to refresh.", false, refresh.isShown()); 
	}
	
	
	@Smoke
	public void test0204_MarketNewsCounts() throws Throwable{
		this.ToMarkets();
		solo.clickOnText("Market News");
		solo.waitForDialogToClose(40000);
		solo.goBack();
		ListView MMover= (ListView)((LinearLayout)solo.getView(R.id.layout_nav_container)).getChildAt(0);
		int MMCount = (int)MMover.getCount();
		assertEquals("Market News count isn't equal to 51.", 51 , MMCount );
	}	

	@Smoke
	public void test0205_MarketNewsDatecheck() throws Throwable{
	    this.ToMarkets();
	    solo.clickOnText("Market News");
        solo.waitForDialogToClose(6000);
        solo.goBack();
        TextView refresh = (TextView)solo.getView(R.id.btn_refresh_market_position_quote);
		assertEquals("Date shows correct", true, refresh.getText().toString().indexOf("(ET)")>=0);
	}
	
	
	
//	@Smoke
//	public void test03_ShakeGesture() throws Throwable{	
//		}
	
private void ToMarkets() throws InterruptedException
    {
		solo.clickOnText("Skip Sign In");
		solo.sleep(5);
    	solo.waitForDialogToClose(60000);    	

    }
}
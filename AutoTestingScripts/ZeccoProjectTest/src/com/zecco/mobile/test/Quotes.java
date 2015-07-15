//Please clear data firstly
package com.zecco.mobile.test;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.TreeMap;

import junit.framework.Assert;

import com.zecco.mobile.R;
import com.zecco.mobile.R.id;
import com.zecco.mobile.activity.login.Login;
import com.zecco.mobile.activity.portfolios.*;
import com.zecco.mobile.usercontrol.ExpandedListView;
import com.zecco.mobile.usercontrol.tab.NavTabBar;

import android.test.suitebuilder.annotation.Smoke;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;


public class Quotes extends TestBase {
	String _QuoteCode = "BAC";
	String symbol = "AAPL";
	boolean _NameMatch;
	boolean _isNewsMatch;
	public Quotes() {
		super("com.zecco.mobile.activity.common", Login.class);
	}

//Quote
///No Recent Quote
	@Smoke
	public void test_NoRencetQuote() throws Throwable{ 
		solo.clickOnText("Skip Sign In");
		solo.waitForDialogToClose(6000);
		solo.clickOnView(solo.getView(R.id.img_quotes));
		TextView QT= (TextView)solo.getView(R.id.quote_record_title);
		String QuoteTitle = QT.getText().toString();
		boolean TextContent = solo.searchText("Search a ticker or name above and it will be listed here for quick access.");
		assertEquals("No Recent Quotes content shows incorrect.", true, TextContent);
		assertEquals("No Recent Quotes title shows incorrect.", "No Recent Quotes", QuoteTitle);
	}
	
///Search Bar
	@Smoke
	public void test_SearchBoxText() throws Throwable{
		this.toQuotesUnsignin();
		EditText sb = (EditText)solo.getView(R.id.text_Position_add_position_portfolios);
		String SBText = sb.getHint().toString();
		assertEquals("Search box text shows incorrect.", "Search Ticker or Name", SBText);
	}
	
    @Smoke
	public void test_SearchBoxInput() throws Throwable{
    	this.toQuotesUnsignin();
    	solo.enterText(R.id.text_Position_add_position_portfolios, "AA");
    	solo.enterText(R.id.text_Position_add_position_portfolios, "PL");
        String searchResult = solo.getText(R.id.text_dropdown_position).toString();
        assertEquals("Search result incorrect.", "AAPL", searchResult);
    }
    
    @Smoke
	public void test_SearchBoxClear() throws Throwable{
    	this.toQuotesUnsignin();
    	solo.enterText(R.id.text_Position_add_position_portfolios, "AA");
    	solo.clickOnImage(R.id.quote_main_searchclose);
		EditText sb = (EditText)solo.getView(R.id.text_Position_add_position_portfolios);
		String SBText = sb.getHint().toString();
		assertEquals("Search box clear failed.", "Search Ticker or Name", SBText);   	
    }
         
    @Smoke
	public void test_SearchResultCount() throws Throwable{
   	this.toQuotesUnsignin();
   	solo.enterText(R.id.text_Position_add_position_portfolios, "A");
   	ExpandedListView resultList = (ExpandedListView)solo.getView(R.id.list_quotes_names);
   	int resultListCount = resultList.getChildCount();
   	assertEquals("Search List count incorrect.", 5, resultListCount);
    }
    
    @Smoke
	public void test_ClickResultonSearchBox() throws Throwable{
   	this.toQuotesUnsignin();
   	solo.enterText(R.id.text_Position_add_position_portfolios, "AApl");
   	solo.clickOnView(solo.getView(R.id.text_dropdown_position));
   	boolean Tloading = solo.searchText("Loading Quote Data");
   	boolean Floading = solo.searchText("Loading Quote Data.");
   	assertEquals("Loading words show incorrect.", false, Tloading & Floading);
   	solo.waitForDialogToClose(10000);
   	boolean showTab = solo.getView(R.id.layout_nav_tabs).isShown();
   	assertEquals("Haven't got the quote detail page.", true, showTab);
    }
    
///Quote panel
    @Smoke
	public void test_RecentQuoteLabel() throws Throwable{
   	this.toQuotesUnsignin();
   	LinearLayout quoteTitle = (LinearLayout)solo.getView(R.id.quote_record_titles);
   	TextView titleSymbol = (TextView)quoteTitle.getChildAt(0);
   	TextView titleLast = (TextView)quoteTitle.getChildAt(1);
   	TextView titleVolume = (TextView)quoteTitle.getChildAt(2);
   	TextView titleDChange = (TextView)quoteTitle.getChildAt(3);
   	assertEquals("Title Symbol displayed incorrect.", "Symbol", titleSymbol.getText().toString());
   	assertEquals("Title Last displayed incorrect.", "Last", titleLast.getText().toString());
   	assertEquals("Title Volume displayed incorrect.", "Volume", titleVolume.getText().toString());
   	assertEquals("Title Today's Change displayed incorrect.", "Today's Change", titleDChange.getText().toString());
    }

// recent panel
    @Smoke
   	public void test_ClickOnRecentQuote() throws Throwable{
      	this.toQuotesUnsignin();     
      	solo.clickInList(1, R.id.list_recent_quotes_portfolios);
      	boolean Tloading = solo.searchText("Loading Quote Data");
      	boolean Floading = solo.searchText("Loading Quote Data.");
      	assertEquals("Loading words show incorrect.", false, Tloading & Floading);
      	solo.waitForDialogToClose(10000);
      	boolean showTab = solo.getView(R.id.layout_nav_tabs).isShown();
      	assertEquals("Haven't got the quote detail page.", true, showTab);
       }
 
    @Smoke
   	public void test_NoDuplicaties() throws Throwable{
       	this.toQuotesUnsignin();
       	for (int i = 0; i < 2; i++) {
           	solo.enterText((EditText)solo.getView(R.id.text_Position_add_position_portfolios), "AApl");
           	solo.sleep(4000);
           	solo.clickOnView(solo.getView(R.id.text_dropdown_position));
            solo.waitForDialogToClose(40000);
            solo.waitForDialogToClose(40000);
           	solo.goBack();
		}
        ListView RecentPanel = (ListView)solo.getView(R.id.list_recent_quotes_portfolios);
//		ArrayList<String> RPanel = new ArrayList<String>();
        String[] Rpanel = new String[RecentPanel.getChildCount()];
		for (int i = 0; i<RecentPanel.getChildCount(); i++) {
//			RPanel.add(((TextView)((LinearLayout)((LinearLayout)RecentPanel.getChildAt(i)).getChildAt(0)).getChildAt(0)).getText().toString());	
			Rpanel[i] = ((TextView)((LinearLayout)((LinearLayout)RecentPanel.getChildAt(i)).getChildAt(0)).getChildAt(0)).getText().toString();
		}
		Map map = new TreeMap();
		int num = 0;
		for (int i = 0; i<Rpanel.length; i++) {
			if(!map.containsKey(Rpanel[i])){
				map.put(Rpanel[i], 1);
			}else{
				num = num + 1;
				break;
			 }
			}
		assertEquals("Exsit duplicaties recent quote.", 0, num);
		}
 
//	from newest to older
    @Smoke
   	public void test_FromNewesttoOlder() throws Throwable{
      	this.toQuotesUnsignin();     
      	solo.clickInList(1, R.id.list_recent_quotes_portfolios);
      	solo.waitForDialogToClose(40000);

       }
//	click any row, it will turn to the top row.
    
//	Up to 16 previous quotes 
   	public void test_Upto16Quotes() throws Throwable{
       	this.toQuotesUnsignin();
       	for (int i = 0; i < 26; i++) {
           	solo.enterText(R.id.text_Position_add_position_portfolios, symbol);
           	solo.sleep(4000);
           	solo.clickOnView(solo.getView(R.id.text_dropdown_position));
           	solo.waitForDialogToClose(40000);
           	solo.goBack();
       		}
		}
    
///	-Quote profile 
    @Smoke
	public void test_ClickBackfromQuoteProfile() throws Throwable{
   	this.toQuotesUnsignin();   
  	solo.clickInList(1, R.id.list_recent_quotes_portfolios);
  	solo.waitForDialogToClose(10000);
  	solo.goBack();
  	boolean Tloading = solo.searchText("Loading Quote Data");
  	boolean Floading = solo.searchText("Loading Quote Data.");
  	assertEquals("Loading words show incorrect.", false, Tloading & Floading);
    }
    
    @Smoke
	public void test_QuoteProfileRefresh() throws Throwable{
    	this.toQuotesUnsignin();
    	this.getSymboltoQuote("AAPL");
    	solo.clickOnImage(R.id.img_refresh_market_position_quote);
    	assertEquals("Fail to add to watchlist.", false, solo.getButton(R.id.btn_refresh_market_position_quote).isShown());
    	
    }

    @Smoke
	public void test_AddtoWatchListNoSign() throws Throwable{
    	this.toQuotesUnsignin();
    	this.getSymboltoQuote("AAPL");
    	solo.clickOnText("Add To Watch List");
    	assertEquals("Fail to refresh.", true, solo.searchText("To access this feature, please sign in or open a new account"));
    	
    }

///Chart Landscape
    @Smoke
	public void test_ChartLandscapeTitle() throws Throwable{   	
    	this.toQuotesUnsignin();
    	this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	HashMap<String, String> h = CheckWidget("Stock");
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	String quotecode = ((TextView)solo.getView(R.id.text_quotecode)).getText().toString();
    	String company = ((TextView)solo.getView(R.id.text_company)).getText().toString();
    	String lastprice = ((TextView)solo.getView(R.id.text_lastprice)).getText().toString();
    	String todaychange = ((TextView)solo.getView(R.id.text_todaychange)).getText().toString();
    	assertEquals("Quote code incorrect.", h.get("Title"), quotecode);
    	assertEquals("Company incorrect.", h.get("Company"), company);
    	assertEquals("LastPrice code incorrect.", h.get("LastPrice"), lastprice);
    	assertEquals("TodayChange code incorrect.", h.get("TodaysChange"), todaychange);
    }	
    
    @Smoke
	public void test_ChartLandscapeTimeframeUnMF() throws Throwable{  
    	this.toQuotesUnsignin();
    	this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	solo.clickOnButton(R.id.btn_timeframe);
    	boolean _1day = solo.getButton(R.id.btn_1day).isShown();//GONE  VISIBLE
    	boolean _5day = solo.getButton(R.id.btn_5day).isShown();
    	boolean _1mo = solo.getButton(R.id.btn_1mo).isShown();
    	boolean _6mo = solo.getButton(R.id.btn_6mo).isShown();
    	boolean _1yr = solo.getButton(R.id.btn_1yr).isShown();
    	boolean _3yr = solo.getButton(R.id.btn_3yr).isShown();
    	boolean max_time = solo.getButton(R.id.btn_max_time).isShown();
    	assertEquals("Timeframe values incorrect.", false, _1day);
    	assertEquals("Timeframe values incorrect.", false, _5day);
    	assertEquals("Timeframe values incorrect.", true, _1mo);
    	assertEquals("Timeframe values incorrect.", true, _6mo);
    	assertEquals("Timeframe values incorrect.", true, _1yr);
    	assertEquals("Timeframe values incorrect.", true, _3yr);
    	assertEquals("Timeframe values incorrect.", true, max_time);
    }
    
    @Smoke
	public void test_ChartLandscapeTimeframeforMF() throws Throwable{   	
    	this.toQuotesUnsignin();
    	this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	solo.clickOnButton(R.id.btn_timeframe);
    	boolean _1day = solo.getButton(R.id.btn_1day).isShown();
    	boolean _5day = solo.getButton(R.id.btn_5day).isShown();
    	boolean _1mo = solo.getButton(R.id.btn_1mo).isShown();
    	boolean _6mo = solo.getButton(R.id.btn_6mo).isShown();
    	boolean _1yr = solo.getButton(R.id.btn_1yr).isShown();
    	boolean _3yr = solo.getButton(R.id.btn_3yr).isShown();
    	boolean max_time = solo.getButton(R.id.btn_max_time).isShown();
    	assertEquals("Timeframe values incorrect.", true, _1day);
    	assertEquals("Timeframe values incorrect.", true, _5day);
    	assertEquals("Timeframe values incorrect.", true, _1mo);
    	assertEquals("Timeframe values incorrect.", true, _6mo);
    	assertEquals("Timeframe values incorrect.", true, _1yr);
    	assertEquals("Timeframe values incorrect.", true, _3yr);
    	assertEquals("Timeframe values incorrect.", true, max_time);
    }
    
    @Smoke
	public void test_ChartLandscapeXbuttonActive() throws Throwable{
     	this.toQuotesUnsignin();
    	this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	//upperX
    	solo.clickOnText("Compare");
    	solo.sleep(1000);
    	solo.clickOnText("DOW");
    	solo.waitForDialogToClose(40000);
    	solo.clickOnImage(R.id.img_chart_land);
    	boolean upperX = solo.getImage(R.id.img_upper_remove).isShown();
    	assertEquals("upperX cannot be clicked.", true, upperX);
    	solo.clickOnImage(R.id.img_upper_remove);
    	solo.sleep(1000);
    	boolean loadChartUper = solo.searchText("Loading Chart");
    	assertEquals("upperX cannot trigger a load page.", true, loadChartUper);
    	solo.waitForDialogToClose(4000);
    	//LowerX
    	solo.clickOnImage(R.id.img_chart_land);
    	solo.clickOnButton(R.id.btn_lowerIndicators);
    	solo.clickOnText("RSI");
    	solo.waitForDialogToClose(40000);
    	solo.clickOnImage(R.id.img_chart_land);
    	boolean lowerX = solo.getImage(R.id.img_lower_remove).isShown();
    	assertEquals("lowerX cannot be clicked.", true, lowerX);
    	solo.clickOnImage(R.id.img_lower_remove);
    	solo.sleep(1000);
    	boolean loadChartLow = solo.searchText("Loading Chart");
    	assertEquals("upperX cannot trigger a load page.", true, loadChartLow);
    }
    
    @Smoke
	public void test_ChartLandscapeXButtonInactive() throws Throwable{   
         	this.toQuotesUnsignin();
        	this.getSymboltoQuote(symbol);
        	solo.sleep(4000);
        	solo.setActivityOrientation(0);
        	solo.sleep(4000);
        	solo.waitForDialogToClose(40000);
        	//upperX
        	boolean upperX = solo.getImage(R.id.img_upper_remove).isShown();
        	boolean clickupperX = solo.getImage(R.id.img_upper_remove).isClickable();
        	assertEquals("upperX should not be clicked.", false, upperX);
        	assertEquals("upperX should not be clicked.", false, clickupperX);
        	//LowerX
        	solo.clickOnImage(R.id.img_chart_land);
        	solo.clickOnButton(R.id.btn_lowerIndicators);
        	solo.clickOnText("RSI");
        	solo.waitForDialogToClose(40000);
        	solo.clickOnImage(R.id.img_chart_land);
        	boolean lowerX = solo.getImage(R.id.img_lower_remove).isShown();
        	assertEquals("lowerX cannot be clicked.", true, lowerX);
        	solo.clickOnImage(R.id.img_lower_remove);
        	solo.sleep(1000);
        	boolean loadChartLow = solo.searchText("Loading Chart");
        	assertEquals("upperX cannot trigger a load page.", true, loadChartLow);	
    }	
    
    @Smoke
    //upper chart
	public void test_ChartLandscapeCompareTitle() throws Throwable{   	
    	
     	this.toQuotesUnsignin();
    	this.getSymboltoQuote(symbol);
    	solo.sleep(400);
    	solo.setActivityOrientation(0);
    	solo.sleep(40);
    	solo.waitForDialogToClose(40000);
    	solo.clickOnText("Compare");
    	String Comparetitle = ((TextView)solo.getView(R.id.text_quote_compare_title)).getText().toString();
    	assertEquals("Compare title incorrect.", "Enter a Ticker to Compare to ".concat(symbol), Comparetitle);
    }
    
    @Smoke
	public void test_ChartLandscapeCompareCancel() throws Throwable{
    	
     	this.toQuotesUnsignin();
    	this.getSymboltoQuote(symbol);
    	solo.sleep(400);
    	solo.setActivityOrientation(0);
    	solo.sleep(40);
    	solo.waitForDialogToClose(40000);
    	solo.clickOnText("Compare");
    	solo.clickOnText("Cancel");
    	boolean Load = solo.searchText("Loading");
    	boolean LChart = solo.searchText("Lower Chart");
    	boolean LIndicators = solo.searchText("Lower Indicators");
    	assertEquals("Fail to back from Compare page.", false, Load & LChart & LIndicators);
    }	
    
    @Smoke
	public void test_ChartLandscapeSearchBox() throws Throwable{   	
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(40);
    	solo.setActivityOrientation(0);
//    	solo.sleep(40);
    	solo.waitForDialogToClose(40000);
    	solo.clickOnText("Compare");
    	String CompareAct = solo.getCurrentActivity().toString();
    	//Operator below
    	String SBText = ((EditText)solo.getView(R.id.text_Position_add_position_portfolios)).getHint().toString();
    	assertEquals("Search box text shows incorrect.", "Search Ticker or Name", SBText);
    	//test_SearchBoxInput()
        solo.enterText((EditText)solo.getView(R.id.text_Position_add_position_portfolios), "aa");
        solo.enterText((EditText)solo.getView(R.id.text_Position_add_position_portfolios), "PL");
        solo.sleep(4000);
        String searchResult = ((TextView)solo.getView(R.id.text_dropdown_position)).getText().toString();
        assertEquals("Search result incorrect.", "AAPL", searchResult);
        //test_SearchBoxClear() 
        solo.clickOnView((ImageView)solo.getView(R.id.quote_main_searchclose));
    	assertEquals("Search box clear failed.", "Search Ticker or Name", SBText);   	
    	//test_SearchResultCount()
       	solo.enterText((EditText)solo.getView(R.id.text_Position_add_position_portfolios), "A");
       	solo.sleep(4000);
       	ExpandedListView resultList = (ExpandedListView)solo.getView(R.id.list_quotes_names);
       	int resultListCount = resultList.getChildCount();
       	assertEquals("Search List count incorrect.", 5, resultListCount);
       	//test_ClickResultonSearchBox()
       	solo.clearEditText((EditText)solo.getView(R.id.text_Position_add_position_portfolios));
       	solo.enterText((EditText)solo.getView(R.id.text_Position_add_position_portfolios), symbol);
       	solo.clickOnView(solo.getView(R.id.text_dropdown_position));
       	boolean Tloading = solo.searchText("Loading Quote Data");
       	boolean Floading = solo.searchText("Loading Quote Data.");
       	assertEquals("Loading words show incorrect.", false, Tloading & Floading);
       	solo.waitForDialogToClose(40000);
       	String LChartAct = solo.getCurrentActivity().toString();  	
       	boolean rst = LChartAct.equals(CompareAct);
       	assertEquals("Haven't got the quote detail page.", false, rst);
       	boolean wordsearch = solo.searchText(symbol);
       	assertEquals("Fail to search Dow on landscape chart page.", true, wordsearch);
    }	
    
    @Smoke
	public void test_ChartLandscapeDOW() throws Throwable{   	
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(400);
    	solo.setActivityOrientation(0);
    	solo.sleep(40);
    	solo.waitForDialogToClose(40000);
    	String a = solo.getCurrentActivity().toString();
    	solo.clickOnText("Compare");
    	//Operator below
    	solo.clickOnText("DOW");
    	solo.sleep(200);
       	boolean Tloading = solo.searchText("Loading Quote Data");
       	boolean Floading = solo.searchText("Loading Quote Data.");
       	assertEquals("Loading words show incorrect.", false, Tloading & Floading);
       	solo.waitForDialogToClose(40000);
       	String b = solo.getCurrentActivity().toString();
       	assertEquals("Fail to click Dow .", b, a);
       	boolean wordsearch = solo.searchText("DOW");
       	assertEquals("Fail to search Dow on landscape chart page.", true, wordsearch);
    }

    @Smoke
	public void test_LandscapeUpperIndicators() throws Throwable{  
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	String a = solo.getCurrentActivity().toString();
    	solo.clickOnText("Compare");
    	//Operator below
    	solo.clickOnText("NYSE Composite");
    	solo.sleep(2000);
       	boolean Tloading = solo.searchText("Loading Quote Data");
       	boolean Floading = solo.searchText("Loading Quote Data.");
       	assertEquals("Loading words show incorrect.", false, Tloading & Floading);
       	solo.waitForDialogToClose(40000);
       	String b = solo.getCurrentActivity().toString();
       	assertEquals("Fail to click Dow .", b, a);
       	boolean wordsearch = solo.searchText("NYSE Composite");
       	assertEquals("Fail to search Dow on landscape chart page.", true, wordsearch);
    }	
    
    @Smoke
	public void test_LandscapeUpperIndicatorsCancel() throws Throwable{   	
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	String a = solo.getCurrentActivity().toString();
    	solo.clickOnText("Compare");
    	//Operator below
    	solo.clickOnText("Cancel");
    	boolean Tloading = solo.searchText("Loading Quote Data");
    	assertEquals("Loading dialog should not be showed.", false, Tloading);
    	String b = solo.getCurrentActivity().toString();
    	assertEquals("Unrearched the landscape chart page.", a, b);
    }	
   
    @Smoke
	public void test_LandscapeUpperChartStyleCancel() throws Throwable{  
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	String a = solo.getCurrentActivity().toString();
    	solo.clickOnText("Chart Style");
    	//Operator below
    	solo.clickOnText("Cancel");
    	boolean Tloading = solo.searchText("Loading Quote Data");
    	assertEquals("Loading dialog should not be showed.", false, Tloading);
    	String b = solo.getCurrentActivity().toString();
    	assertEquals("Unrearched the landscape chart page.", a, b);
    }
    
    @Smoke
	public void test_LandscapeChartStyle() throws Throwable{
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	String a = solo.getCurrentActivity().toString();
    	solo.clickOnText("Chart Style");
    	//Operator below
    	solo.clickOnText("Line");
    	boolean Tloading = solo.searchText("Loading Quote Data");
    	assertEquals("Loading dialog should not be showed.", true, Tloading);
    	solo.waitForDialogToClose(40000);
    	String b = solo.getCurrentActivity().toString();
    	assertEquals("Unrearched the landscape chart page.", a, b);
    }	
    
    @Smoke
	public void test_LandscapeLowerIndicatorCancel() throws Throwable{
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	String a = solo.getCurrentActivity().toString();
    	solo.clickOnText("Lower Indicators");
    	//Operator below
    	boolean LIndTitle = solo.searchText("Select a Lower Indicator to Add to the Chart");
    	assertEquals("Lower Indicator page title shows incorrect.", true, LIndTitle);
    	solo.clickOnText("Cancel");
    	boolean Tloading = solo.searchText("Loading Quote Data");
    	assertEquals("Loading dialog should not be showed.", false, Tloading);
    	solo.waitForDialogToClose(40000);
    	String b = solo.getCurrentActivity().toString();
    	assertEquals("Unrearched the landscape chart page.", a, b); 
    }	
    
    @Smoke
	public void test_LandscapeLowerIndicators() throws Throwable{
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	String a = solo.getCurrentActivity().toString();
    	solo.clickOnText("Lower Indicators");
    	//Operator below
    	///Check all buttons text
    	assertEquals("Text[Lower Indicators] cannot be found.", true, solo.searchText("Lower Indicators")); 
    	assertEquals("Text[No Lower Indicator] cannot be found.",true, solo.searchText("No Lower Indicator"));
    	assertEquals("Text[Volume+] cannot be found.",true, solo.searchText("Volume+"));
    	assertEquals("Text[MACD] cannot be found.",true, solo.searchText("MACD"));
    	assertEquals("Text[PROC] cannot be found.",true, solo.searchText("PROC"));
    	assertEquals("Text[VROC] cannot be found.",true, solo.searchText("VROC"));
    	assertEquals("Text[Rolling EPS] cannot be found.",true, solo.searchText("Rolling EPS"));
    	assertEquals("Text[RSI] cannot be found.",true, solo.searchText("RSI"));
    	assertEquals("Text[DMI] cannot be found.",true, solo.searchText("DMI"));
    	assertEquals("Text[PE Ratio] cannot be found.",true, solo.searchText("PE Ratio"));
    	assertEquals("Text[Chaikins Volatility] cannot be found.",true, solo.searchText("Chaikins Volatility"));
    	assertEquals("Text[Stochastics Slow] cannot be found.",true, solo.searchText("Stochastics Slow"));
    	assertEquals("Text[Stochastics Fast] cannot be found.",true, solo.searchText("Stochastics Fast"));
    	solo.clickOnText("PE Ratio");
    	solo.sleep(10);
    	assertEquals("Dialog[Loading Chart] shows incorrect.",false, solo.searchText("Loading Chart") & solo.searchText("Loading Chart."));
    	solo.waitForDialogToClose(40000);
    	String b = solo.getCurrentActivity().toString();
    	assertEquals("Unrearched the landscape chart page.", a, b); 
    	assertEquals("P/E Ratio on landscape page cannot be found.",true, solo.searchText("P/E Ratio"));
    	solo.clickOnText("P/E Ratio");
    	assertEquals("P/E Ratio on landscape page cannot be found.",true, solo.searchText("P/E Ratio"));
    }
    
    @Smoke
 	public void test_ChartLandscapeIndexTitle() throws Throwable{
    	this.toQuotesUnsignin();
    	this.getSymboltoQuote("^SPX");
    	solo.sleep(400);
    	HashMap<String, String> h = CheckWidget("Stock");
    	solo.setActivityOrientation(0);
    	solo.sleep(40);
    	solo.waitForDialogToClose(40000);
    	String quotecode = ((TextView)solo.getView(R.id.text_quotecode)).getText().toString();
    	String company = ((TextView)solo.getView(R.id.text_company)).getText().toString();
    	String lastprice = ((TextView)solo.getView(R.id.text_lastprice)).getText().toString();
    	String todaychange = ((TextView)solo.getView(R.id.text_todaychange)).getText().toString();
    	assertEquals("Quote code incorrect.", h.get("Title"), quotecode);
    	assertEquals("Company incorrect.", h.get("Company"), company);
    	assertEquals("LastPrice code incorrect.", "$".concat(h.get("LastPrice")), lastprice);
    	assertEquals("TodayChange code incorrect.", h.get("TodaysChange"), todaychange);
    }	
    
    @Smoke
 	public void test_rotatetoPortait() throws Throwable{
        this.toQuotesUnsignin();
        this.getSymboltoQuote(symbol);
        String a = solo.getCurrentActivity().toString();
    	solo.sleep(4000);
    	solo.setActivityOrientation(0);
    	solo.sleep(4000);
    	solo.waitForDialogToClose(40000);
    	solo.clickOnText("Chart Style");
    	//Operator below
    	solo.clickOnText("Line");
    	solo.waitForDialogToClose(40000);
        solo.setActivityOrientation(1);
        solo.waitForDialogToClose(40000);
    	String b = solo.getCurrentActivity().toString();
    	assertEquals("Unrearched the landscape chart page.", a, b);
    	
    }	

    //	Tabs
	private void ChartTab() throws InterruptedException{
         //check rotate infor;
	}
 
	private void NewsTab() throws InterruptedException{
		this.clickTab("News");
		solo.waitForDialogToClose(40000);
		String _NewsTitleTab = solo.getView(R.id.text_newstitle_list_news).toString();
		solo.clickOnView(solo.getView(R.id.text_newstitle_list_news));
		solo.sleep(200);
	    String _NewsTitleDetail = solo.getView(R.id.text_newstitle).toString();
        	if (_NewsTitleTab.equals(_NewsTitleDetail))
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
	
	private void MarketMoversTab() throws InterruptedException{
		this.clickTab("Movers");
		solo.waitForDialogToClose(40000);
		boolean _CheckMovers= solo.isTextChecked("Volume");
	    boolean  expected_CheckMovers = true;
		boolean actual_CheckMovers =_CheckMovers;
		assertEquals("The Movers Tab loading failed.", expected_CheckMovers, actual_CheckMovers);
	}
	
	private void OptionsTab() throws InterruptedException{
		this.clickTab("Options");
		solo.waitForDialogToClose(40000);
		solo.clickOnText("Expiration");
		solo.isTextChecked("Cancel");
		solo.clickOnText("Cancel");
		solo.clickOnText("Expiration");
		solo.isTextChecked("Select");
		solo.clickOnText("Select");
		solo.waitForDialogToClose(40000);
		solo.clickOnText("View All");
		solo.waitForDialogToClose(40000);
		boolean _CheckViewAll= solo.isTextChecked("View All");
        boolean  expected_ViewAll = false;
		boolean  actual_ViewAll = _CheckViewAll;
		assertEquals("View All should be hidden.", expected_ViewAll, actual_ViewAll); 
	}

	private void CommunityTab() throws InterruptedException{

	}
	
	private void ProfileTab() throws InterruptedException{
		this.clickTab("Profile");
		solo.waitForDialogToClose(40000);
		boolean _CheckPOpen= solo.isTextChecked("Price Open");
	    boolean  expected_CheckPOpen = true;
		boolean actual_CheckPOpen =_CheckPOpen;
		assertEquals("The ProfileTab loading failed.", expected_CheckPOpen, actual_CheckPOpen);
	}
	
	private void PortfoliosTab() throws InterruptedException{
		this.clickTab("Portfolio");
		solo.waitForDialogToClose(40000);
		boolean _CheckPortfolio= solo.isTextChecked("Top 10 Holdings");
	    boolean  expected_CheckPortfolio = true;
		boolean actual_CheckPortfolio =_CheckPortfolio;
		assertEquals("The Portfolios Tab loading failed.", expected_CheckPortfolio, actual_CheckPortfolio);
	}

////Type
    @Smoke
    public void test01_QuoteIndex() throws Throwable{ 
//	this.CheckQuote(_QuoteCode, "Index");
    }

	@Smoke
	public void test02_QuoteIndexOther() throws Throwable{ 
	//Balance check
	//tab check
	//landscape check(title)
	//Add to watch list
	}
	
	@Smoke
	public void test03_QuoteStoke() throws Throwable{ 
	
	}
	
	@Smoke
	public void test04_QuoteETFs() throws Throwable{ 
	
	}
	
	@Smoke
	public void test05_QuoteMF() throws Throwable{ 
	
	}
	
	@Smoke
	public void test06_QuoteOther() throws Throwable{ 
	
	}

	 private void CheckQuote(String _SymbolCode, String _SymbolType ) throws InterruptedException
	    {
		//Sign In
		 this.toQuotesUnsignin();
	   	//QuotePage
	   	solo.enterText(0, _SymbolCode);
	   	solo.sleep(10000);
	    ExpandedListView elv= (ExpandedListView)solo.getView(R.id.list_quotes_names);    
	    LinearLayout ll = (LinearLayout)elv.getChildAt(0);
	    String _SymbolCodeQuote = ll.getChildAt(0).toString();
	    assertEquals("Result failed.", _SymbolCode, _SymbolCodeQuote);
	   	String _SymbolComQuote = ll.getChildAt(1).toString();
	    solo.clickOnView(elv.getChildAt(0));
	    solo.sleep(20);
        solo.waitForDialogToClose(60000);
        //QuoteDetail
        String _SymbolCodeQuoteProfile = solo.getView(R.id.text_quote_market_position_quote).toString();
	    String _SymbolcomQuoteProfile = solo.getView(R.id.text_company_market_position_quote).toString();
	    if(_SymbolCodeQuoteProfile.equals(_SymbolCodeQuote) && _SymbolComQuote.equals(_SymbolcomQuoteProfile))
	    	{
	    		_NameMatch = true; 
	    	}
	    else
	    	{
	    		_NameMatch = false;
	    	}
	    boolean  expected_NameMatch = true;
		boolean actual_NameMatch =_NameMatch;
		assertEquals("Your Symbol name is unmatched.", expected_NameMatch, actual_NameMatch); 
		//CheckTab
		CheckTab(_SymbolType);
	    }
	 
	 
	 
	 ////////////////////////////////////////////////////////////////////////

		
		private void toQuotesUnsignin() throws InterruptedException{
			solo.clickOnText("Skip Sign In");
			solo.waitForDialogToClose(40000);
			solo.clickOnView(solo.getView(R.id.img_quotes));
			solo.waitForDialogToClose(40000);
		}
		
		private void toQuotesSignin() throws InterruptedException{
			UserSignIn();
			solo.waitForDialogToClose(40000);
			solo.clickOnView(solo.getView(R.id.img_quotes));
			solo.waitForDialogToClose(40000);
		}
		
		private void getSymboltoQuote(String _symbol) throws InterruptedException{
		   	EditText a = (EditText)solo.getView(R.id.text_Position_add_position_portfolios);
		   	solo.enterText(a, _symbol);
		   	solo.sleep(2000);
		    solo.clickOnView(solo.getView(R.id.text_dropdown_position));
		   	solo.waitForDialogToClose(40000);
		}
		
		private void clickTab(String _tab) throws InterruptedException{
		NavTabBar tabs = (NavTabBar)solo.getView(R.id.layout_nav_tabs);
		for (int i = 0; i < tabs.getChildCount(); i++) {
			Button tab = (Button)tabs.getChildAt(i);
			if(tab.getText().toString() == _tab)
				{
					solo.clickOnView(tab);
					break;
				}	
			}
					
	
		}
	}
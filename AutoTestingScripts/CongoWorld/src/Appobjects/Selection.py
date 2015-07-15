'''
Created on 2010-10-9

@author: christie.duan
'''
import Appobjects.PublicFunctions as PublicFunctions


def Year(self,year):        
    PublicFunctions.my_wait_element(self, "//a[@id='searchyear']/span")
    self.selenium.click("//a[@id='searchyear']/span")
    #self.selenium.click(year)
    self.selenium.click("ui-multiselect-searchyear-option-1")
    self.selenium.click("//div[@id='mmyform_year']/div/div/ul/li[3]/a")

   
    
def Make(self,make):
    PublicFunctions.my_wait_element(self,"mmy_make")  
    self.selenium.click("mmy_make")
    PublicFunctions.my_wait_element(self,"make_more")
    self.selenium.click("link="+make)
    PublicFunctions.my_wait_title(self,make)
    
#def Categories(self,categories): 
    
def Categories_QP(self,categories):
    PublicFunctions.my_wait_element(self,"link="+categories)      
    self.selenium.click("link="+categories)
    PublicFunctions.my_wait_title(self,categories)
    
    
def Brand(self,brand):
    PublicFunctions.my_wait_element(self,"link="+brand)
    self.selenium.click("link="+brand)

def Products(self):
    PublicFunctions.my_wait_element(self,"//img[contains(@src,'/templates/default/images/view.gif')]")
    self.selenium.click("//img[contains(@src,'/templates/default/images/view.gif')]")

def smartsearch(self,searchkey):
    PublicFunctions.my_wait_element(self,"search_query")
    self.selenium.type("search_query", searchkey)
    self.selenium.click("//div[@id='SearchFormContent']/form/input[4]")
    
def couponcode(self,value):
    PublicFunctions.my_wait_element(self,"couponcode")
    self.selenium.type("couponcode", value)
    self.selenium.click("//div[@id='CartContent']/div/div[1]/table/thead[1]/tr/td[2]/input[2]")
    
    
    
    
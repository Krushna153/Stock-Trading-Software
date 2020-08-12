import requests,bs4
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.keys import Keys
url="http://localhost/welcome.php"
browser = webdriver.Chrome(executable_path='C:\\Users\\OM\\AppData\\Local\\Programs\\Python\\Python38-32\\chromedriver.exe')
browser.get(url)
navigationStart = browser.execute_script("return window.performance.timing.navigationStart")
responseStart = browser.execute_script("return window.performance.timing.responseStart")
domComplete = browser.execute_script("return window.performance.timing.domComplete")

backendPerformance_calc = responseStart - navigationStart
frontendPerformance_calc = domComplete - responseStart
 
print("Back End in login phase millisecond: %s" % backendPerformance_calc)
print("Front End in login phase millisecond: %s" % frontendPerformance_calc)
username = WebDriverWait(browser,1).until(lambda browser: browser.find_element_by_id('username'))
username.send_keys("Mihir")
password = WebDriverWait(browser,1).until(lambda browser: browser.find_element_by_id('password'))
password.send_keys("yoyomihir")
login = WebDriverWait(browser,1).until(lambda browser: browser.find_element_by_name('submit'))
login.click()


navigationStart = browser.execute_script("return window.performance.timing.navigationStart")
responseStart = browser.execute_script("return window.performance.timing.responseStart")
domComplete = browser.execute_script("return window.performance.timing.domComplete")

backendPerformance_calc = responseStart - navigationStart
frontendPerformance_calc = domComplete - responseStart
 
print("Back End in dashboard millisecond: %s" % backendPerformance_calc)
print("Front End in dashboard millisecond: %s" % frontendPerformance_calc)

order = WebDriverWait(browser,1).until(lambda browser: browser.find_element_by_id('neworder_tab'))
order.click()


navigationStart = browser.execute_script("return window.performance.timing.navigationStart")
responseStart = browser.execute_script("return window.performance.timing.responseStart")
domComplete = browser.execute_script("return window.performance.timing.domComplete")

backendPerformance_calc = responseStart - navigationStart
frontendPerformance_calc = domComplete - responseStart
 
print("Back End in order tab millisecond: %s" % backendPerformance_calc)
print("Front End in order tab millisecond: %s" % frontendPerformance_calc)

set_stock_size = WebDriverWait(browser,10).until(lambda browser: browser.find_element_by_name('stocksize'))
print(set_stock_size)
set_stock_size.click()

set_MIS = WebDriverWait(browser,4).until(lambda browser: browser.find_element_by_id('MIS'))
set_MIS.click() 
set_order_type = WebDriverWait(browser,4).until(lambda browser: browser.find_element_by_name('order-type'))
set_order_type.click()
submit = WebDriverWait(browser,4).until(lambda browser: browser.find_element_by_xpath('//*[@id="orderform"]/div[4]/input'))
submit.click()

navigationStart = browser.execute_script("return window.performance.timing.navigationStart")
responseStart = browser.execute_script("return window.performance.timing.responseStart")
domComplete = browser.execute_script("return window.performance.timing.domComplete")

backendPerformance_calc = responseStart - navigationStart
frontendPerformance_calc = domComplete - responseStart
 
print("Back End in After order placed millisecond: %s" % backendPerformance_calc)
print("Front End in After order placed millisecond: %s" % frontendPerformance_calc)





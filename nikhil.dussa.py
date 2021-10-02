from tkinter import *
import requests
from datetime import datetime
#key=ENTER YOUR API KEY HERE AND THEN UNCOMMENT
#link used to get weather data
url="https://api.openweathermap.org/data/2.5/forecast"
#degree symbol
degree= u'\N{DEGREE SIGN}'
#Function that's called everytime the search button is clicked.
#It pulls the city name from the entry, gets the weather data from
#openweathermap.org, and formats it into two seperate lists.
#one in the format [today's date,tomorrow's date,day after's date] and one
#in the format [[temperature,weather description, time of day in UTC],...]
#for the rest of today and the next two days
#It then passes those two lists into the refine function
def clicked():
    try:
        user_entry=entry.get()
        entry.delete(0, 'end')
        data={"APPID":key,"q":user_entry,"units":"imperial"}
        #Gets data from openweathermap.org
        response=requests.get(url,params=data)
        weather_info=response.json()
        #gets the current utc time to compare to data later
        today=str(datetime.utcnow())[8:10]
        count=0
        date_count=0
        full_day=[]
        dates=[]
        country_info.configure(text=weather_info["city"]["name"]+", "+weather_info["city"]["country"],bg="white",font=("times new roman",15))
        for x in weather_info["list"]:
            #used to get the dates of today, tomorrow, and the day after
            if x["dt_txt"][:10] not in dates and date_count<3:
                date_count+=1
                dates.append(x["dt_txt"][:10])
            #both these if and elif are used to get the 3 day weather data
            if (int(today)==int(x["dt_txt"][8:10])):
                full_day.append([x["main"]["temp"],x["weather"][0]["description"],x["dt_txt"][11:16]])
            elif count<17:
                count+=1
                full_day.append([x["main"]["temp"],x["weather"][0]["description"],x["dt_txt"][11:16]])

        refine(full_day,dates)
    #used if user input is invalid
    except:
        day_1.configure(text="",bg="#2cced3")
        day_2.configure(text="",bg="#2cced3")
        day_3.configure(text="",bg="#2cced3")
        country_info.configure(text="Sorry! An error occurred!\nplease try again!",bg="white",font=("times new roman",15))
        the_canvas.create_rectangle(50,170,290,510,outline="",fill="#2cced3")
        the_canvas.create_rectangle(280,170,520,510,outline="",fill="#2cced3")
        the_canvas.create_rectangle(510,170,760,510,outline="",fill="#2cced3")
#takes data from the clicked function and formats it onto the GUI
def refine(day_info,dates):
    today,tomorrow,day_after=(dates[0]+"\n"+("-"*15)+"\n",dates[1]+"\n"+("-"*15)+"\n",dates[2]+"\n"+("-"*15)+"\n")
    for x in day_info[:len(day_info)-16]:
        today+=x[2]+" - "+str(x[0])+" "+degree+"F"+" - "+x[1]+"\n\n"
    for x in day_info[len(day_info)-16:len(day_info)-8:]:
        tomorrow+=x[2]+" - "+str(x[0])+" "+degree+"F"+" - "+x[1]+"\n\n"
    for x in day_info[len(day_info)-8:]:
        day_after+=x[2]+" - "+str(x[0])+" "+degree+"F"+" - "+x[1]+"\n\n"
    the_canvas.create_rectangle(50,170,290,500,fill="white")
    the_canvas.create_rectangle(280,170,520,500,fill="white")
    the_canvas.create_rectangle(510,170,750,500,fill="white")
    day_1.configure(text=today,bg="white")
    day_2.configure(text=tomorrow,bg="white")
    day_3.configure(text=day_after,bg="white")
#This chunk of code sets up the GUI including
#the window,logo,entry,button,and all text labels
window=Tk()
window.title("3-Day Weather Forecast")
window.geometry("800x500")
window.resizable(False, False)
the_canvas=Canvas(window,height=510,width=810,bg="#2cced3")
button=Button(window,text="Search",border=5,pady=0,font=("times new roman",13),command=clicked)
title=Label(window,text="3-Day Weather Forecast",font=("times new roman",35),bg="#d3312c",fg="white")
day_1=Label(window,text="",font=("times new roman",10),wraplength=230,justify=LEFT,bg="#2cced3",fg="black")
day_2=Label(window,text="",font=("times new roman",10),wraplength=230,justify=LEFT,bg="#2cced3",fg="black")
day_3=Label(window,text="",font=("times new roman",10),wraplength=230,justify=LEFT,bg="#2cced3",fg="black")
country_info=Label(window,text="Hello! Please enter the name of the city you would like to know the weather of!",font=("times new roman",10),wraplength=160,bg="white",fg="black")
the_canvas.place(x=-5,y=-5)
the_canvas.create_oval(140,3,190,63,outline="",fill="#92e6f2")
the_canvas.create_oval(145,3,195,63,outline="",fill="#2461db")
the_canvas.create_oval(150,3,200,63,outline="",fill="#d3312c")
the_canvas.create_oval(616,3,666,63,outline="",fill="#92e6f2")
the_canvas.create_oval(611,3,661,63,outline="",fill="#2461db")
the_canvas.create_oval(606,3,656,63,outline="",fill="#d3312c")
the_canvas.create_oval(-80,-80,70,70,outline="",fill="#2461db")
the_canvas.create_oval(-80,-80,60,60,outline="",fill="#92e6f2")
the_canvas.create_oval(740,-80,890,70,outline="",fill="#2461db")
the_canvas.create_oval(750,-80,890,60,outline="",fill="#92e6f2")
the_canvas.create_rectangle(222,78,564,128,outline="",fill="#92e6f2")
the_canvas.create_rectangle(25,78,210,166,fill="white")
country_info.place(x=40,y=88)
day_3.place(x=520,y=170)
day_2.place(x=290,y=170)
day_1.place(x=60,y=170)
title.pack(side=TOP)
entry=Entry(window,width=40,border=10)
entry.place(x=290,y=80)
button.place(x=224,y=80)
window.mainloop()
